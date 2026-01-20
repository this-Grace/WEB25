<?php

require_once __DIR__ . '/Database.php';

/**
 * Report model for handling report-related database operations.
 * 
 * This class provides methods for managing user reports and moderation.
 */
class Report
{
    /**
     * @var mysqli Database connection instance.
     */
    private $db;

    /**
     * Constructor - initializes database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Retrieve all reports from the database.
     * 
     * @return array Array of report records.
     */
    public function all(): array
    {
        $query = "SELECT r.id, r.reporter_username, r.reported_post_id, r.reported_username, 
                         r.reason, r.description, r.status, r.created_at, r.updated_at,
                         p.title as post_title 
                  FROM reports r 
                  LEFT JOIN posts p ON r.reported_post_id = p.id 
                  ORDER BY r.created_at DESC";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Find a report by ID.
     * 
     * @param int $id The report ID.
     * @return array|null Report data if found, null otherwise.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT r.id, r.reporter_username, r.reported_post_id, r.reported_username, 
                    r.reason, r.description, r.status, r.created_at, r.updated_at,
                    p.title as post_title, p.content as post_content 
             FROM reports r 
             LEFT JOIN posts p ON r.reported_post_id = p.id 
             WHERE r.id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $data ?: null;
    }

    /**
     * Get reports by status.
     * 
     * @param string $status Report status filter.
     * @return array Array of reports with the given status.
     */
    public function getByStatus(string $status): array
    {
        $stmt = $this->db->prepare(
            "SELECT r.id, r.reporter_username, r.reported_post_id, r.reported_username, 
                    r.reason, r.description, r.status, r.created_at, r.updated_at,
                    p.title as post_title 
             FROM reports r 
             LEFT JOIN posts p ON r.reported_post_id = p.id 
             WHERE r.status = ? 
             ORDER BY r.created_at DESC"
        );
        $stmt->bind_param('s', $status);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        return $data;
    }

    /**
     * Get statistics about reports.
     * 
     * @return array Associative array with report counts by status.
     */
    public function getStats(): array
    {
        $query = "SELECT status, COUNT(*) as count FROM reports GROUP BY status";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        $stats = [
            'pending' => 0,
            'resolved' => 0,
            'blocked' => 0,
            'rejected' => 0
        ];

        foreach ($data as $row) {
            $key = strtolower(str_replace(' ', '_', $row['status']));
            if (isset($stats[$key])) {
                $stats[$key] = (int)$row['count'];
            }
        }

        return $stats;
    }

    /**
     * Create a new report.
     * 
     * @param string $reporterUsername Username of the reporter.
     * @param int $reportedPostId ID of the reported post.
     * @param string $reportedUsername Username being reported.
     * @param string $reason Report reason.
     * @param string|null $description Optional description.
     * @return int|bool Report ID if creation successful, false otherwise.
     */
    public function create(string $reporterUsername, int $reportedPostId, string $reportedUsername, string $reason, ?string $description = null): int|false
    {
        $stmt = $this->db->prepare(
            "INSERT INTO reports (reporter_username, reported_post_id, reported_username, reason, description) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sisss', $reporterUsername, $reportedPostId, $reportedUsername, $reason, $description);

        $success = $stmt->execute();
        $reportId = $this->db->insert_id;
        $stmt->close();

        return $success ? $reportId : false;
    }

    /**
     * Update report status.
     * 
     * @param int $id Report ID.
     * @param string $status New status.
     * @return bool True if update successful, false otherwise.
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE reports SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Delete a report from the database.
     * 
     * @param int $id Report ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM reports WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
