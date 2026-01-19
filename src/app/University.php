<?php

require_once __DIR__ . '/Database.php';

/**
 * University model for handling university-related database operations.
 * 
 * This class provides methods for CRUD operations on university records.
 */
class University
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
     * Retrieve all universities from the database.
     * 
     * @return array Array of university records.
     */
    public function all(): array
    {
        $query = "SELECT id, name, city, created_at FROM universities ORDER BY name ASC";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Find a university by ID.
     * 
     * @param int $id The university ID.
     * @return array|null University data if found, null otherwise.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, city, created_at FROM universities WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $data ?: null;
    }

    /**
     * Create a new university record.
     * 
     * @param string $name University name.
     * @param string|null $city City where the university is located.
     * @return int|bool University ID if creation successful, false otherwise.
     */
    public function create(string $name, ?string $city = null): int|false
    {
        $stmt = $this->db->prepare("INSERT INTO universities (name, city) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $city);

        $success = $stmt->execute();
        $universityId = $this->db->insert_id;
        $stmt->close();

        return $success ? $universityId : false;
    }

    /**
     * Update a university record.
     * 
     * @param int $id University ID to update.
     * @param string $name Updated university name.
     * @param string|null $city Updated city.
     * @return bool True if update successful, false otherwise.
     */
    public function update(int $id, string $name, ?string $city = null): bool
    {
        $stmt = $this->db->prepare("UPDATE universities SET name = ?, city = ? WHERE id = ?");
        $stmt->bind_param('ssi', $name, $city, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Delete a university from the database.
     * 
     * @param int $id University ID to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM universities WHERE id = ?");
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
