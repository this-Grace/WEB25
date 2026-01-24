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
        $sql = "SELECT AVG((total_seats - available_seats) / NULLIF(total_seats,0)) * 100 AS avgp FROM EVENT WHERE status = 'APPROVED' AND event_date < NOW()";
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
        $sql = "SELECT COUNT(*) AS cnt FROM EVENT WHERE event_date < NOW() AND status = 'APPROVED'";
        $res = $this->db->prepareAndExecute($sql, []);
        if (!$res || !($res instanceof mysqli_result)) return 0;
        $row = $res->fetch_assoc();
        return (int)($row['cnt'] ?? 0);
    }
}
