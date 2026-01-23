<?php

/**
 * CATEGORY Class
 * A data mapper for the CATEGORY table providing CRUD operations.
 * Uses prepared statements to prevent SQL injection.
 */
class Category
{
    /**
     * @var DatabaseHelper $db Database helper instance
     */
    private $db;

    /**
     * Constructor - Initializes with DatabaseHelper
     *
     * @param DatabaseHelper $db DatabaseHelper instance
     */
    public function __construct(DatabaseHelper $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve all CATEGORY
     *
     * @return array An array of associative arrays with keys `id` and `name`
     */
    public function findAll(): array
    {
        $sql = 'SELECT id, name FROM CATEGORY ORDER BY id';
        $res = $this->db->prepareAndExecute($sql, []);
        if (!$res || !($res instanceof mysqli_result)) return [];
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
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
        $sql = 'SELECT id, name FROM CATEGORY WHERE name = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$name]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
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
        $sql = 'SELECT id, name FROM CATEGORY WHERE id = ? LIMIT 1';
        $res = $this->db->prepareAndExecute($sql, [$id]);
        if (!$res || !($res instanceof mysqli_result)) return null;
        $row = $res->fetch_assoc();
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
        $sql = 'INSERT INTO CATEGORY (name) VALUES (?)';
        $ok = $this->db->prepareAndExecute($sql, [$name]);
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
        $sql = 'UPDATE CATEGORY SET name = ? WHERE id = ?';
        $ok = $this->db->prepareAndExecute($sql, [$newName, $id]);
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
        $sql = 'DELETE FROM CATEGORY WHERE id = ?';
        $ok = $this->db->prepareAndExecute($sql, [$id]);
        return (bool)$ok;
    }
}
