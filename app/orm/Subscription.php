<?php

/**
 * SUBSCRIPTION Class
 * Data mapper for the SUBSCRIPTION table.
 */
class Subscription
{
    /** @var DatabaseHelper $db */
    private $db;

    /**
     * Constructor
     * @param DatabaseHelper $db
     */
    public function __construct(DatabaseHelper $db)
    {
        $this->db = $db;
    }

    /**
     * Create a new subscription
     * @param string $userEmail
     * @param int $eventId
     * @param string $participationCode
     * @param string $status
     * @return bool
     */
    public function create(string $userEmail, int $eventId, string $participationCode, string $status = 'REGISTERED'): bool
    {
        $sql = 'INSERT INTO SUBSCRIPTION (user_email, event_id, participation_code, status) VALUES (?, ?, ?, ?)';
        $ok = $this->db->prepareAndExecute($sql, [$userEmail, $eventId, $participationCode, $status]);
        return (bool)$ok;
    }

    /**
     * Find subscription by id
     * @param int $id
     * @return array|null
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
     * @param string $code
     * @return array|null
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
     * @param string $email
     * @param int $eventId
     * @return array|null
     */
    public function findByUserAndEvent(string $email, int $eventId): ?array
    {
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE user_email = ? AND event_id = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$email, $eventId]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
        return $row ?: null;
    }

    /**
     * List subscriptions by user
     * @param string $email
     * @return array
     */
    public function findByUser(string $email): array
    {
        $sql = 'SELECT * FROM SUBSCRIPTION WHERE user_email = ? ORDER BY subscription_date DESC';
        $res = $this->db->prepareAndExecute($sql, [$email]);
        if (!$res || !($res instanceof mysqli_result)) return [];
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    /**
     * List subscriptions by event
     * @param int $eventId
     * @return array
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
     * @param int $id
     * @param string $status
     * @param bool $setCheckin If true set checkin_time to NOW(), if false leave unchanged
     * @return bool
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
     * @param int $id
     * @return bool
     */
    public function markPresent(int $id): bool
    {
        return $this->updateStatus($id, 'PRESENT', true);
    }

    /**
     * Mark a subscription as ABSENT
     * @param int $id
     * @return bool
     */
    public function markAbsent(int $id): bool
    {
        return $this->updateStatus($id, 'ABSENT', false);
    }

    /**
     * Cancel a subscription
     * @param int $id
     * @return bool
     */
    public function cancel(int $id): bool
    {
        return $this->updateStatus($id, 'CANCELLED', false);
    }

    /**
     * Delete subscription
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM SUBSCRIPTION WHERE subscription_id = ?';
        return (bool)$this->db->prepareAndExecute($sql, [$id]);
    }
}
