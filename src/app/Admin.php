<?php

require_once __DIR__ . '/Database.php';

/**
 * Admin model for handling admin-related database operations.
 * 
 * This class provides methods for managing admin users.
 */
class Admin
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
     * Retrieve all admins from the database.
     * 
     * @return array Array of admin records with user information.
     */
    public function all(): array
    {
        $query = "SELECT a.username, u.email, u.first_name, u.surname, a.created_at 
                  FROM admins a 
                  JOIN users u ON a.username = u.username 
                  ORDER BY a.created_at DESC";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Check if a user is an admin.
     * 
     * @param string $username Username to check.
     * @return bool True if user is admin, false otherwise.
     */
    public function isAdmin(string $username): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM admins WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        $isAdmin = $stmt->num_rows > 0;
        $stmt->close();

        return $isAdmin;
    }

    /**
     * Add a user as admin.
     * 
     * @param string $username Username to make admin.
     * @return bool True if successful, false otherwise.
     */
    public function create(string $username): bool
    {
        $stmt = $this->db->prepare("INSERT INTO admins (username) VALUES (?)");
        $stmt->bind_param('s', $username);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Remove admin privileges from a user.
     * 
     * @param string $username Username to remove admin privileges from.
     * @return bool True if successful, false otherwise.
     */
    public function delete(string $username): bool
    {
        $stmt = $this->db->prepare("DELETE FROM admins WHERE username = ?");
        $stmt->bind_param('s', $username);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
