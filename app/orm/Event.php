<?php

/**
 * Event Class
 * A data mapper for the EVENT table providing common queries and updates.
 * Uses prepared statements to prevent SQL injection.
 */
class Event
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
     * Base SELECT clause for event queries (common columns)
     * @return string
     */
    private function baseEventSelect(): string
    {
        return "SELECT e.id, e.title, e.description, e.event_date, e.event_time, e.location, e.total_seats, e.occupied_seats, e.status, e.image, e.user_email, e.category_id, c.name AS category ";
    }

    /**
     * Append a LIMIT clause if $limit > 0
     * @param string $sql
     * @param int $limit
     * @return string
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
     * @param string $sql
     * @param array $params
     * @return array
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
     * @return int
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
     * Returns a float percentage (0-100)
     * @return float
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
     * @return int
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
     * @return array
     */
    public function getAllEvents(int $limit = 0): array
    {
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql);
    }

    /**
     * Events visible to normal users: only events with status = 'APPROVED'
     * @param int $limit
     * @return array
     */
    public function getApprovedEvents(int $limit = 0): array
    {
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "WHERE e.status = 'APPROVED' " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql);
    }

    /**
     * Events visible to a host: all APPROVED events plus the host's own events in WAITING status
     * @param string $hostEmail
     * @param int $limit
     * @return array
     */
    public function getEventsForHost(string $hostEmail, int $limit = 0): array
    {
        $sql = $this->baseEventSelect() .
            "FROM EVENT e LEFT JOIN CATEGORY c ON e.category_id = c.id " .
            "WHERE (e.status = 'APPROVED') OR (e.user_email = ? AND e.status = 'WAITING') " .
            "ORDER BY e.event_date DESC, e.event_time DESC";

        $sql = $this->applyLimit($sql, $limit);
        return $this->fetchEvents($sql, [$hostEmail]);
    }

    /**
     * Events visible to admin: all events (wrapper for getAllEvents)
     * @param int $limit
     * @return array
     */
    public function getEventsForAdmin(int $limit = 0): array
    {
        return $this->getAllEvents($limit);
    }
}
