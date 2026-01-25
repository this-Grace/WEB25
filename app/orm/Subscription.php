<?php

/**
 * Subscription Class
 * 
 * Data mapper for the SUBSCRIPTION table.
 * Handles user event subscriptions, check-ins, and status management.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @package DataMappers
 * @author Alessandro Rebosio
 * @version 1.0
 */
class Subscription
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
     * Create a new subscription
     * 
     * @param mixed $user User identifier (email or numeric id)
     * @param int $eventId Event ID to subscribe to
     * @param string $participationCode Unique participation code
     * @param string $status Initial subscription status (default: 'REGISTERED')
     * @return bool True on success, false on failure
     */
    public function create($user, int $eventId, string $participationCode, string $status = 'REGISTERED'): bool
    {
        $userId = $this->resolveUserId($user);
        if ($userId === null) return false;
        $sql = 'INSERT INTO SUBSCRIPTION (user_id, event_id, participation_code, status) VALUES (?, ?, ?, ?)';
        $ok = $this->db->prepareAndExecute($sql, [$userId, $eventId, $participationCode, $status]);
        return (bool)$ok;
    }

    /**
     * Find subscription by id
     * 
     * @param int $id Subscription ID
     * @return array|null Subscription data or null if not found
     */
    public function findById(int $id): ?array
    {
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE subscription_id = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$id]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
        return $row ?: null;
    }

    /**
     * Find subscription by participation code
     * 
     * @param string $code Participation code
     * @return array|null Subscription data or null if not found
     */
    public function findByCode(string $code): ?array
    {
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE participation_code = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$code]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
        return $row ?: null;
    }

    /**
     * Find a subscription by user and event
     * 
     * @param mixed $user User identifier (email or numeric id)
     * @param int $eventId Event ID
     * @return array|null Subscription data or null if not found
     */
    public function findByUserAndEvent($user, int $eventId): ?array
    {
        $userId = $this->resolveUserId($user);
        if ($userId === null) return null;
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE user_id = ? AND event_id = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$userId, $eventId]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
        return $row ?: null;
    }

    /**
     * Find all event IDs a user is subscribed to from a given list of event IDs.
     * 
     * @param mixed $user User identifier (email or numeric id)
     * @param array $eventIds Array of event IDs to check
     * @return array Array of event IDs that the user is subscribed to
     */
    public function findSubscribedEventsByUser($user, array $eventIds): array
    {
        if (empty($eventIds)) {
            return [];
        }

        $userId = $this->resolveUserId($user);
        if ($userId === null) return [];

        $placeholders = implode(',', array_fill(0, count($eventIds), '?'));
        $sql = "SELECT DISTINCT event_id FROM SUBSCRIPTION WHERE user_id = ? AND event_id IN ($placeholders)";

        $params = array_merge([$userId], $eventIds);

        $res = $this->db->prepareAndExecute($sql, $params);

        if (!$res || !($res instanceof mysqli_result)) {
            return [];
        }

        $subscribedEventIds = [];
        while ($row = $res->fetch_assoc()) {
            $subscribedEventIds[] = $row['event_id'];
        }

        return $subscribedEventIds;
    }

    /**
     * List subscriptions by user
     * 
     * @param mixed $user User identifier (email or numeric id)
     * @return array Array of subscription records for the user
     */
    public function findByUser($user): array
    {
        $userId = $this->resolveUserId($user);
        if ($userId === null) return [];
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE user_id = ? ORDER BY subscription_date DESC';
        $res = $this->db->prepareAndExecute($sql, [$userId]);
        if (!$res || !($res instanceof mysqli_result)) return [];
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Resolve a user identifier (email or numeric id) to a numeric user id.
     * 
     * @param mixed $user User identifier (email or numeric id)
     * @return int|null Numeric user ID or null if not found
     */
    private function resolveUserId($user): ?int
    {
        if (is_int($user) || ctype_digit((string)$user)) {
            return (int)$user;
        }
        if (!is_string($user)) return null;

        $sql = 'SELECT id FROM USER WHERE email = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$user]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
        return $row ? (int)$row['id'] : null;
    }

    /**
     * List subscriptions by event
     * 
     * @param int $eventId Event ID
     * @return array Array of subscription records for the event
     */
    public function findByEvent(int $eventId): array
    {
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE event_id = ? ORDER BY subscription_date ASC';
        $res = $this->db->prepareAndExecute($sql, [$eventId]);
        if (!$res || !($res instanceof mysqli_result)) return [];
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * Update status of a subscription
     * 
     * @param int $id Subscription ID
     * @param string $status New status
     * @param bool $setCheckin If true set checkin_time to NOW(), if false leave unchanged
     * @return bool True on success, false on failure
     */
    public function updateStatus(int $id, string $status, bool $setCheckin = false): bool
    {
        if ($setCheckin) {
            $sql = 'UPDATE SUBSCRIPTION SET status = ?, checkin_time = CURRENT_TIMESTAMP WHERE subscription_id = ?';
            return (bool)$this->db->prepareAndExecute($sql, [$status, $id]);
        }
        $sql = 'UPDATE SUBSCRIPTION SET status = ? WHERE subscription_id = ?';
        return (bool)$this->db->prepareAndExecute($sql, [$status, $id]);
    }

    /**
     * Mark a subscription as PRESENT and set checkin time
     * 
     * @param int $id Subscription ID
     * @return bool True on success, false on failure
     */
    public function markPresent(int $id): bool
    {
        return $this->updateStatus($id, 'PRESENT', true);
    }

    /**
     * Mark a subscription as ABSENT
     * 
     * @param int $id Subscription ID
     * @return bool True on success, false on failure
     */
    public function markAbsent(int $id): bool
    {
        return $this->updateStatus($id, 'ABSENT', false);
    }

    /**
     * Cancel a subscription
     * 
     * @param int $id Subscription ID
     * @return bool True on success, false on failure
     */
    public function cancel(int $id): bool
    {
        return $this->updateStatus($id, 'CANCELLED', false);
    }

    /**
     * Delete subscription
     * 
     * @param int $id Subscription ID
     * @return bool True on success, false on failure
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM SUBSCRIPTION WHERE subscription_id = ?';
        return (bool)$this->db->prepareAndExecute($sql, [$id]);
    }
}
