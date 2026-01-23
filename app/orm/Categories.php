<?php

/**
 * Categories Class
 * A data mapper for the CATEGORIES table providing CRUD operations.
 * Uses prepared statements to prevent SQL injection.
 */
class Categories
{
    /**
     * @var mysqli $conn MySQLi database connection
     */
    private $conn;

    /**
     * Constructor - Initializes with a MySQLi connection
     *
     * @param mysqli $conn MySQLi database connection instance
     */
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Retrieve all categories
     *
     * @return array An array of associative arrays with keys `id` and `name`
     */
    public function findAll(): array
    {
        $sql = 'SELECT id, name FROM CATEGORIES ORDER BY id';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /**
     * Find a category by its name
     *
     * @param string $name Category name
     * @return array|null Associative array with `id` and `name` or null if not found
     */
    public function findByName(string $name): ?array
    {
        $sql = 'SELECT id, name FROM CATEGORIES WHERE name = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Find a category by its id
     *
     * @param int $id Category id
     * @return array|null Associative array with `id` and `name` or null if not found
     */
    public function findById(int $id): ?array
    {
        $sql = 'SELECT id, name FROM CATEGORIES WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Check if a category exists by name
     *
     * @param string $name Category name
     * @return bool True if exists, false otherwise
     */
    public function exists(string $name): bool
    {
        return $this->findByName($name) !== null;
    }

    /**
     * Create a new category
     *
     * @param string $name Category name
     * @return bool True on success, false on failure
     */
    public function create(string $name): bool
    {
        $sql = 'INSERT INTO CATEGORIES (name) VALUES (?)';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Update a category name by id
     *
     * @param int $id Category id
     * @param string $newName New category name
     * @return bool True on success, false on failure
     */
    public function updateName(int $id, string $newName): bool
    {
        $sql = 'UPDATE CATEGORIES SET name = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('si', $newName, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Delete a category by id
     *
     * @param int $id Category id
     * @return bool True on success, false on failure
     */
    public function deleteById(int $id): bool
    {
        $sql = 'DELETE FROM CATEGORIES WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }
}
