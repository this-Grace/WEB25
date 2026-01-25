<?php

/**
 * Event Class
 * 
 * A data mapper for the EVENT table providing common queries and updates.
 * Handles event retrieval, statistics, and filtering based on user roles.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @package DataMappers
 * @author Alessandro Rebosio
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
        // select e.user_id and user's email for backward-compatible templates that expect user_email
        return "SELECT e.id, e.title, e.description, e.event_date, e.event_time, e.location, e.total_seats, e.occupied_seats, e.status, e.image, e.user_id, u.email AS user_email, e.category_id, c.name AS category ";
    }

    /**
     * Append a LIMIT clause if $limit > 0
     * 
     * @param string $sql SQL query
     * @param int $limit Maximum number of records to return
     * @return string SQL query with LIMIT clause if applicable
     */
    private function applyLimit(string $sql, int $limit): string
    {
        $limit = (int)$limit;
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit;
        }
        return $sql;
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
     * Number of events happening in the current month
     * 
     * @return int Count of approved events in current month
     */
    public function getEventsThisMonth(): int
    {
        $sql = "SELECT COUNT(*) AS cnt FROM EVENT WHERE MONTH(event_date) = MONTH(CURRENT_DATE()) AND YEAR(event_date) = YEAR(CURRENT_DATE()) AND status = 'APPROVED'";
        $res = $this->db->prepareAndExecute($sql, []);
        if (!$res || !($res instanceof mysqli_result)) return 0;
        $row = $res->fetch_assoc();
        return (int)($row['cnt'] ?? 0);
    }

    /**
     * Average participation percentage across published events
     * 
     * Returns a float percentage (0-100) representing average participation
     * Only considers approved events that have already happened
     * 
     * @return float Average participation percentage
     */
    public function getAvgParticipationPercent(): float
    {
        // Use occupied_seats and DATE comparison for event_date
        $sql = "SELECT AVG(NULLIF(occupied_seats,0) / NULLIF(total_seats,0)) * 100 AS avgp FROM EVENT WHERE status = 'APPROVED' AND event_date < CURRENT_DATE()";
        $res = $this->db->prepareAndExecute($sql, []);
        if (!$res || !($res instanceof mysqli_result)) return 0.0;
        $row = $res->fetch_assoc();
        return isset($row['avgp']) ? (float)$row['avgp'] : 0.0;
    }

    /**
     * Count events that already happened (completed)
     * 
     * @return int Count of approved events with past dates
     */
    public function getCompletedEventsCount(): int
    {
        // event_date is DATE; compare with CURRENT_DATE()
        $sql = "SELECT COUNT(*) AS cnt FROM EVENT WHERE event_date < CURRENT_DATE() AND status = 'APPROVED'";
        $res = $this->db->prepareAndExecute($sql, []);
        if (!$res || !($res instanceof mysqli_result)) return 0;
        $row = $res->fetch_assoc();
        return (int)($row['cnt'] ?? 0);
    }

    /**
     * Retrieve all events, optionally limited.
     * Joins category name and orders by date/time descending (newest first).
     *
     * @param int $limit Maximum number of events to return (0 = no limit)
     * @return array Array of event data with category and user information
     */
    public function getAllEvents(int $limit = 0): array
    {
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN USER u ON e.user_id = u.id LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "WHERE (e.status IS NULL OR e.status <> 'DRAFT') " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql);
    }

    /**
     * Events visible to normal users: only events with status = 'APPROVED' or 'CANCELLED'
     * 
     * @param int $limit Maximum number of events to return (0 = no limit)
     * @return array Array of approved or cancelled events with category and user information
     */
    public function getApprovedOrCancelledEvents(int $limit = 0): array
    {
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN USER u ON e.user_id = u.id LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "WHERE e.status = 'APPROVED' OR e.status = 'CANCELLED' " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql);
    }

    /**
     * Events visible to a host: all APPROVED events plus the host's own events in WAITING status
     * 
     * @param string $hostEmail Email of the host user
     * @param int $limit Maximum number of events to return (0 = no limit)
     * @return array Array of events visible to the host
     */
    public function getEventsForHost(string $hostEmail, int $limit = 0): array
    {
        // keep interface accepting host email for convenience; join USER to compare email
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN USER u ON e.user_id = u.id LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "WHERE (e.status = 'APPROVED') OR (u.email = ? AND e.status = 'WAITING') " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql, [$hostEmail]);
    }

    /**
     * Events visible to admin: all events (wrapper for getAllEvents)
     * 
     * @param int $limit Maximum number of events to return (0 = no limit)
     * @return array Array of all events regardless of status
     */
    public function getEventsForAdmin(int $limit = 0): array
    {
        return $this->getAllEvents($limit);
    }

    /**
     * Get events a user is subscribed to
     * @param int $userId User ID
     * @return array Array of events the user is subscribed to
     */
    public function getEventsSubscribedByUser(int $userId): array
    {
        $sql = $this->baseEventSelect() .
            " FROM EVENT e 
          JOIN SUBSCRIPTION s ON e.id = s.event_id 
          LEFT JOIN USER u ON e.user_id = u.id
          LEFT JOIN CATEGORY c ON e.category_id = c.id
          WHERE s.user_id = ? AND e.event_date >= CURRENT_DATE()
          ORDER BY e.event_date ASC";
        return $this->fetchEvents($sql, [$userId]);
    }

    /**
     * Get events organized by a user with specific statuses
     * @param int $userId User ID
     * @param array $statuses Array of statuses to filter by (e.g. ['DRAFT', 'WAITING'])
     * @return array Array of events organized by the user with the specified statuses
     */
    public function getEventsOrganizedByUser(int $userId, array $statuses): array
    {
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));
        $sql = $this->baseEventSelect() .
            " FROM EVENT e 
          LEFT JOIN USER u ON e.user_id = u.id
          LEFT JOIN CATEGORY c ON e.category_id = c.id
          WHERE e.user_id = ? AND e.status IN ($placeholders)
          AND e.event_date >= CURRENT_DATE()
          ORDER BY e.event_date ASC";
        return $this->fetchEvents($sql, array_merge([$userId], $statuses));
    }

    /**
     * Get user's event history (past events or cancelled) 
     * @param int $userId User ID
     * @return array Array of past or cancelled events organized by or subscribed to by the user
     */
    public function getUserEventHistory(int $userId): array
    {
        $sql = $this->baseEventSelect() .
            " FROM EVENT e 
          LEFT JOIN USER u ON e.user_id = u.id
          LEFT JOIN CATEGORY c ON e.category_id = c.id
          WHERE (e.user_id = ? OR e.id IN (SELECT event_id FROM SUBSCRIPTION WHERE user_id = ?))
          AND (e.event_date < CURRENT_DATE() OR e.status = 'CANCELLED')
          ORDER BY e.event_date DESC";
        return $this->fetchEvents($sql, [$userId, $userId]);
    }
}
