<?php

/**
 * Event Class
 * 
 * A data mapper for the EVENT table providing common queries and updates.
 * Handles event retrieval, statistics, and filtering based on user roles.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @package DataMappers
 * @author Grazia Bochdanovits de Kavna
 * @version 1.0
 */
class Event
{
    /**
     * Database helper instance
     * @var DatabaseHelper $db
     */
    private $db;

    /**
     * Constructor
     * 
     * @param DatabaseHelper $db Database helper instance
     */
    public function __construct(DatabaseHelper $db)
    {
        $this->db = $db;
    }

    /**
     * Base SELECT clause for event queries (common columns)
     * 
     * @return string SQL SELECT clause with common event columns
     */
    private function baseEventSelect(): string
    {
        return "SELECT 
                e.*, 
                c.name AS category_name 
            FROM EVENT e 
            LEFT JOIN USER u ON e.user_id = u.id 
            LEFT JOIN CATEGORY c ON e.category_id = c.id ";
    }

    /**
     * Execute a query and return associative rows array
     * 
     * @param string $sql SQL query to execute
     * @param array $params Query parameters
     * @return array Array of associative arrays representing event rows
     */
    private function fetchEvents(string $sql, array $params = []): array
    {
        $res = $this->db->prepareAndExecute($sql, $params);
        if (!$res || !($res instanceof mysqli_result)) return [];

        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Get event statistics including monthly count, completed events, and average participation
     * 
     * @return array Associative array with statistics (monthly_count, completed_count, avg_participation)
     */
    public function getStats(): array
    {
        $sql = "SELECT 
            (SELECT COUNT(*) FROM EVENT WHERE MONTH(event_date) = MONTH(CURRENT_DATE()) AND YEAR(event_date) = YEAR(CURRENT_DATE()) AND status = 'APPROVED') as monthly_count,
            (SELECT COUNT(*) FROM EVENT WHERE (event_date < CURRENT_DATE() OR (event_date = CURRENT_DATE() AND event_time < CURRENT_TIME())) AND status = 'APPROVED') as completed_count,
            (SELECT AVG(occupied_seats / total_seats) * 100 FROM EVENT WHERE status = 'APPROVED' AND event_date < CURRENT_DATE()) as avg_participation";

        $res = $this->db->prepareAndExecute($sql, []);
        return ($res instanceof mysqli_result) ? $res->fetch_assoc() : [];
    }

    /**
     * Flexible paginated event fetcher that supports role-based visibility, category filtering,
     * and special filters like 'miei' (host's own events) or 'waiting' (admin review queue).
     *
     * @param string $role User role (admin|host|other)
     * @param int|null $currentUserId Current user's ID (required for host role and special filters)
     * @param int $limit Number of records to return
     * @param int $offset Offset for pagination
     * @param int|null $categoryId Optional category id to filter
     * @param string|null $specialFilter Optional special filter ('miei'|'waiting')
     * @param string|null $search Optional search term to filter events by title, location, or category name
     * @return array Array of event rows
     */
    public function getEventsWithFilters(
        string $role,
        ?int $currentUserId = null,
        int $limit = 6,
        int $offset = 0,
        ?int $categoryId = null,
        ?string $specialFilter = null,
        ?string $search = null
    ): array {
        $params = [];
        $sql = $this->baseEventSelect() . " WHERE 1=1 ";

        switch ($role) {
            case 'admin':
                break;

            default:
                $sql .= " AND e.status = 'APPROVED' ";
        }

        if ($specialFilter === 'miei' && $currentUserId) {
            $sql .= " AND e.user_id = ? ";
            $params[] = $currentUserId;
        }

        if ($specialFilter === 'waiting' && $role === 'admin') {
            $sql .= " AND e.status = 'WAITING' ";
        }

        if ($categoryId !== null) {
            $sql .= " AND e.category_id = ? ";
            $params[] = $categoryId;
        }

        if ($search !== null && $search !== '') {
            $like = "%{$search}%";
            $sql .= " AND (e.title LIKE ? OR e.location LIKE ? OR c.name LIKE ?) ";
            array_push($params, $like, $like, $like);
        }

        if ($specialFilter !== 'miei') {
            $sql .= " AND (e.event_date > CURRENT_DATE() OR (e.event_date = CURRENT_DATE() AND e.event_time >= CURRENT_TIME())) ";
        }

        $sql .= " ORDER BY e.event_date DESC, e.event_time DESC LIMIT ?, ? ";
        array_push($params, $offset, $limit);

        return $this->fetchEvents($sql, $params);
    }

    /**
     * Get events a user is subscribed to
     * 
     * @param int $userId User ID
     * @return array Array of events the user is subscribed to
     */
    public function getSubscriptionsByUserId(int $userId): array
    {
        $sql = $this->baseEventSelect() .
            " JOIN SUBSCRIPTION s ON e.id = s.event_id 
                 WHERE s.user_id = ? AND e.event_date >= CURRENT_DATE() 
                 ORDER BY e.event_date ASC";
        return $this->fetchEvents($sql, [$userId]);
    }

    /**
     * Get events organized by a user with specific statuses
     * 
     * @param int $userId User ID
     * @param array $statuses Array of statuses to filter by (e.g. ['DRAFT', 'WAITING'])
     * @param bool $onlyFuture If true, only returns future events; if false, includes all events
     * @return array Array of events organized by the user with the specified statuses
     */
    public function getEventsOrganizedByUser(int $userId, array $statuses, bool $onlyFuture = true): array
    {
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));
        $sql = $this->baseEventSelect() . " WHERE e.user_id = ? AND e.status IN ($placeholders) ";

        if ($onlyFuture) {
            $sql .= " AND (e.event_date > CURRENT_DATE() OR (e.event_date = CURRENT_DATE() AND e.event_time >= CURRENT_TIME())) ";
            $sql .= " ORDER BY e.event_date ASC";
        } else {
            $sql .= " ORDER BY e.event_date DESC";
        }

        return $this->fetchEvents($sql, array_merge([$userId], $statuses));
    }

    /**
     * Get user's event history (past events or cancelled) 
     * 
     * @param int $userId User ID
     * @return array Array of past or cancelled events organized by or subscribed to by the user
     */
    public function getUserEventHistory(int $userId): array
    {
        $sql = $this->baseEventSelect() .
            " WHERE (e.user_id = ? OR e.id IN (SELECT event_id FROM SUBSCRIPTION WHERE user_id = ?))
             AND e.status = 'APPROVED' 
             AND (e.event_date < CURRENT_DATE() OR (e.event_date = CURRENT_DATE() AND e.event_time < CURRENT_TIME()))
             ORDER BY e.event_date DESC";

        return $this->fetchEvents($sql, [$userId, $userId]);
    }

    /**
     * Get event by ID with category and user info
     * 
     * @param int $id Event ID
     * @return array|null Event data as associative array or null if not found
     */
    public function getEventById(int $id): ?array
    {
        $sql = $this->baseEventSelect() . " WHERE e.id = ? LIMIT 1";
        $rows = $this->fetchEvents($sql, [$id]);
        return $rows[0] ?? null;
    }

    /**
     * Cancel an event (only if user is the organizer)
     * 
     * @param int $eventId Event ID to cancel
     * @param int $userId User ID of the organizer (for authorization)
     * @return bool True on success, false on failure
     */
    public function cancel(int $eventId, int $userId): bool
    {
        $sql = "UPDATE EVENT SET status = 'CANCELLED' WHERE id = ? AND user_id = ?";
        return $this->db->prepareAndExecute($sql, [$eventId, $userId]) !== false;
    }

    /**
     * Create a new event
     * 
     * @param array $data Associative array of event data (column => value)
     * @return int Inserted event ID
     */
    public function create(array $data): int
    {
        $keys = array_keys($data);
        $sql = "INSERT INTO EVENT (" . implode(',', $keys) . ") VALUES (" . implode(',', array_fill(0, count($keys), '?')) . ")";
        $this->db->prepareAndExecute($sql, array_values($data));
        return (int)$this->db->getConnection()->insert_id;
    }

    /**
     * Update event data
     * 
     * @param array $data Associative array of fields to update (column => value)
     * @param int $id Event ID
     * @return bool True on success, false on failure
     */
    public function update(array $data, int $id): bool
    {
        $fields = array_map(fn($key) => "$key = ?", array_keys($data));
        $params = array_values($data);
        $params[] = $id;
        return $this->db->prepareAndExecute("UPDATE EVENT SET " . implode(',', $fields) . " WHERE id = ?", $params) !== false;
    }

    /**
     * Delete an event by id
     * 
     * @param int $id Event ID
     * @return bool True on success, false on failure
     */
    public function delete(int $id): bool
    {
        return $this->db->prepareAndExecute("DELETE FROM EVENT WHERE id = ?", [$id]) !== false;
    }
}
