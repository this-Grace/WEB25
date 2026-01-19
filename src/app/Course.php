<?php

require_once __DIR__ . '/Database.php';

/**
 * Course model for handling course-related database operations.
 * 
 * This class provides methods for CRUD operations on course records.
 */
class Course
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
     * Retrieve all courses from the database.
     * 
     * @return array Array of course records.
     */
    public function all(): array
    {
        $query = "SELECT c.id, c.name, c.degree_level, c.university_id, u.name as university_name, c.created_at 
                  FROM courses c 
                  LEFT JOIN universities u ON c.university_id = u.id 
                  ORDER BY c.name ASC";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Find a course by ID.
     * 
     * @param int $id The course ID.
     * @return array|null Course data if found, null otherwise.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT c.id, c.name, c.degree_level, c.university_id, u.name as university_name, c.created_at 
             FROM courses c 
             LEFT JOIN universities u ON c.university_id = u.id 
             WHERE c.id = ? LIMIT 1"
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
     * Get courses by university.
     * 
     * @param int $universityId The university ID.
     * @return array Array of courses for the given university.
     */
    public function getByUniversity(int $universityId): array
    {
        $stmt = $this->db->prepare(
            "SELECT id, name, degree_level, university_id, created_at 
             FROM courses 
             WHERE university_id = ? 
             ORDER BY name ASC"
        );
        $stmt->bind_param('i', $universityId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $result->free();
        $stmt->close();

        return $data;
    }

    /**
     * Create a new course record.
     * 
     * @param string $name Course name.
     * @param string $degreeLevel Degree level (Triennale, Magistrale, Dottorato).
     * @param int $universityId University ID.
     * @return int|bool Course ID if creation successful, false otherwise.
     */
    public function create(string $name, string $degreeLevel, int $universityId): int|false
    {
        $stmt = $this->db->prepare("INSERT INTO courses (name, degree_level, university_id) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $name, $degreeLevel, $universityId);

        $success = $stmt->execute();
        $courseId = $this->db->insert_id;
        $stmt->close();

        return $success ? $courseId : false;
    }

    /**
     * Update a course record.
     * 
     * @param int $id Course ID to update.
     * @param string $name Updated course name.
     * @param string $degreeLevel Updated degree level.
     * @param int $universityId Updated university ID.
     * @return bool True if update successful, false otherwise.
     */
    public function update(int $id, string $name, string $degreeLevel, int $universityId): bool
    {
        $stmt = $this->db->prepare("UPDATE courses SET name = ?, degree_level = ?, university_id = ? WHERE id = ?");
        $stmt->bind_param('ssii', $name, $degreeLevel, $universityId, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Delete a course from the database.
     * 
     * @param int $id Course ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
