<?php

/**
 * User Class
 * A data mapper for the USERS table providing CRUD operations and authentication.
 * Uses prepared statements to prevent SQL injection.
 */
class User
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
     * Find a user by email address
     * 
     * @param string $email User's email address
     * @return array|null Associative array with user data or null if not found
     *                    Returns: email, name, surname, password, role, registration_date
     */
    public function findByEmail(string $email): ?array
    {
        $sql = 'SELECT email, name, surname, password, role, registration_date FROM USERS WHERE email = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Check if a user exists by email address
     * 
     * @param string $email User's email address to check
     * @return bool True if user exists, false otherwise
     */
    public function exists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    /**
     * Create a new user in the database
     * 
     * @param string $email User's email address
     * @param string $name User's first name
     * @param string $surname User's last name
     * @param string $password Plain text password (will be hashed)
     * @param string $role User role (default: 'USER')
     * @return bool True if creation successful, false otherwise
     */
    public function create(string $email, string $name, string $surname, string $password, string $role = 'USER'): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO USERS (email, name, surname, password, role) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('sssss', $email, $name, $surname, $hash, $role);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Update a user's profile information
     * 
     * @param string $email User's current email address
     * @param string $name User's new first name
     * @param string $surname User's new last name
     * @param string $newEmail User's new email address
     * @return bool True if update successful, false otherwise
     */
    public function updateProfile(string $email, string $name, string $surname, string $newEmail): bool
    {
        $sql = 'UPDATE USERS SET name = ?, surname = ?, email = ? WHERE email = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('ssss', $name, $surname, $newEmail, $email);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Update a user's avatar path
     * 
     * @param string $email User's email address
     * @param string $avatarPath New avatar file path
     * @return bool True if update successful, false otherwise
     */
    public function updateAvatar(string $email, ?string $avatarPath): bool
    {
        $sql = 'UPDATE USERS SET avatar = ? WHERE email = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('ss', $avatarPath, $email);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Authenticate a user with email and password
     * 
     * @param string $email User's email address
     * @param string $password Plain text password to verify
     * @return array|null User data without password on success, null on failure
     *                    Returns: email, name, surname, role, registration_date
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;
        $hash = $user['password'] ?? null;
        if ($hash && password_verify($password, $hash)) {
            // Remove password hash from returned data for security
            unset($user['password']);
            return $user;
        }
        return null;
    }

    /**
     * Update a user's password
     * 
     * @param string $email User's email address
     * @param string $newPassword New plain text password (will be hashed)
     * @return bool True if update successful, false otherwise
     */
    public function updatePassword(string $email, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = 'UPDATE USERS SET password = ? WHERE email = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('ss', $hash, $email);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }

    /**
     * Delete a user by email address
     * 
     * @param string $email User's email address to delete
     * @return bool True if deletion successful, false otherwise
     */
    public function delete(string $email): bool
    {
        $sql = 'DELETE FROM USERS WHERE email = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('s', $email);
        $ok = $stmt->execute();
        $stmt->close();
        return (bool)$ok;
    }
}
