<?php

require_once __DIR__ . '/Database.php';

/**
 * User model for handling user-related database operations.
 * 
 * This class provides methods for CRUD operations on user records,
 * including authentication, profile management, and data retrieval.
 */
class User
{
    /**
     * @var mysqli Database connection instance.
     */
    private $db;

    /**
     * Constructor - initializes database connection.
     * 
     * Uses the Singleton Database class to establish a database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Retrieve all users from the database.
     * 
     * @return array Array of user records, each as an associative array.
     *               Returns empty array if no users found or query fails.
     */
    public function all()
    {
        $query = "SELECT username, email, first_name, surname, bio, avatar_url, degree_course, role, created_at FROM users";
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Find a user by username.
     * 
     * @param string $username The username to search for.
     * @return array|null Associative array containing user data if found, null otherwise.
     */
    public function find($username)
    {
        $stmt = $this->db->prepare("SELECT username, email, first_name, surname, bio, avatar_url, degree_course, role, created_at FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Authenticate user credentials.
     * 
     * @param string $username The username to authenticate.
     * @param string $password The plain text password to verify.
     * @return array|bool Returns user data (with username and role) if authentication successful,
     *                    false otherwise.
     */
    public function checkLogin($username, $password)
    {
        $stmt = $this->db->prepare("SELECT username, password_hash, role FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Return user data (excluding password_hash for security)
            return [
                'username' => $user['username'],
                'role' => $user['role']
            ];
        }
        return false;
    }

    /**
     * Create a new user record.
     * 
     * @param string $username Desired username.
     * @param string $email User's email address.
     * @param string $password Plain text password (will be hashed).
     * @param string $first_name User's first name.
     * @param string $surname User's surname.
     * @param string $course User's degree course.
     * @return bool True if creation successful, false otherwise.
     */
    public function create($username, $email, $password, $first_name, $surname, $course)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, first_name, surname, degree_course) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $username, $email, $hash, $first_name, $surname, $course);
        return $stmt->execute();
    }

    /**
     * Update user profile information.
     * 
     * @param string $username Username of the user to update.
     * @param string $first_name Updated first name.
     * @param string $surname Updated surname.
     * @param string $bio Updated biography.
     * @param string $course Updated degree course.
     * @param string $avatar Updated avatar URL or path.
     * @return bool True if update successful, false otherwise.
     */
    public function update($username, $first_name, $surname, $bio, $course, $avatar)
    {
        $stmt = $this->db->prepare("UPDATE users SET first_name = ?, surname = ?, bio = ?, degree_course = ?, avatar_url = ? WHERE username = ?");
        $stmt->bind_param('ssssss', $first_name, $surname, $bio, $course, $avatar, $username);
        return $stmt->execute();
    }

    /**
     * Delete a user from the database.
     * 
     * @param string $username Username of the user to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete($username)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        return $stmt->execute();
    }
}
