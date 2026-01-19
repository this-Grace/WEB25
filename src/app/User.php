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
    public function all(): array
    {
        $query = "SELECT u.username, u.email, u.first_name, u.surname, u.bio, u.avatar_url,
                         u.faculty_id, u.blocked_until, u.created_at, u.updated_at,
                         CASE WHEN a.username IS NOT NULL THEN 'admin' ELSE 'user' END AS role
                  FROM users u
                  LEFT JOIN admins a ON u.username = a.username";
        $result = $this->db->query($query);

        if (!$result) return [];

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $data;
    }

    /**
     * Count total number of users.
     * 
     * @return int Total user count.
     */
    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM users");
        if (!$result) return 0;

        $count = $result->fetch_assoc()['count'] ?? 0;
        $result->free();

        return (int)$count;
    }

    /**
     * Find user by username or email (for login)
     *
     * @param string $value Username or email
     * @return array|null User data including password hash
     */
    public function find(string $value): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT u.username, u.email, u.password_hash, u.first_name, u.surname,
                    u.bio, u.avatar_url, u.faculty_id, u.blocked_until,
                    CASE WHEN a.username IS NOT NULL THEN 'admin' ELSE 'user' END AS role
             FROM users u
             LEFT JOIN admins a ON u.username = a.username
             WHERE u.username = ? OR u.email = ?
             LIMIT 1"
        );

        $stmt->bind_param('ss', $value, $value);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $result->free();
        $stmt->close();

        return $user ?: null;
    }

    /**
     * Authenticate user credentials.
     * 
     * @param string $login The username or email to authenticate.
     * @param string $password The plain text password to verify.
     *  @return array|null User data if valid, null otherwise
     */
    public function checkLogin($login, $password): ?array
    {
        $user = $this->find($login);
        if (!$user) return null;

        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        unset($user['password_hash']);
        return $user;
    }

    /**
     * Check if an email is already registered.
     * 
     * @param string $email The email address to check.
     * @return bool True if email exists, false otherwise.
     */
    public function emailExists($email): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    /**
     * Check if a username is already taken.
     * 
     * @param string $username The username to check.
     * @return bool True if username exists, false otherwise.
     */
    public function usernameExists($username): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    /**
     * Block a user until a specified date.
     * * @param string $username The username of the user to block.
     * @param string|null $until The date until which the user is blocked (YYYY-MM-DD HH:MM:SS).
     *                           If null, the user is blocked indefinitely.
     * @return bool True if successful, false otherwise.
     */
    public function block(string $username, ?string $until = null): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET blocked_until = ? WHERE username = ?");

        $stmt->bind_param('ss', $until, $username);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Create a new user record.
     * 
     * @param string $username Desired username.
     * @param string $email User's email address.
     * @param string $password Plain text password (will be hashed).
     * @param string $first_name User's first name.
     * @param string $surname User's surname.
     * @param string $faculty_id ID of the faculty the user belongs to.
     * @return bool True if creation successful, false otherwise.
     */
    public function create($username, $email, $password, $first_name, $surname, $faculty_id): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $faculty_id = ($faculty_id && is_numeric($faculty_id)) ? (int)$faculty_id : null;

        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password_hash, first_name, surname, faculty_id)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssssi', $username, $email, $hash, $first_name, $surname, $faculty_id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Update user profile information.
     * 
     * @param string $username Username of the user to update.
     * @param string $first_name Updated first name.
     * @param string $surname Updated surname.
     * @param string $bio Updated biography.
     * @param string $faculty_id Updated faculty ID.
     * @param string $avatar Updated avatar URL or path.
     * @return bool True if update successful, false otherwise.
     */
    public function update($username, $first_name, $surname, $bio, $faculty_id, $avatar): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET first_name = ?, surname = ?, bio = ?, faculty_id = ?, avatar_url = ? WHERE username = ?"
        );
        $stmt->bind_param('ssisss', $first_name, $surname, $bio, $faculty_id, $avatar, $username);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Delete a user from the database.
     * 
     * @param string $username Username of the user to delete.
     * @return bool True if deletion successful, false otherwise.
     */
    public function delete($username): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Suspend a user for a specified number of days.
     * 
     * @param string $username Username to suspend.
     * @param int $days Number of days to suspend (default 30).
     * @return bool True if successful, false otherwise.
     */
    public function suspend(string $username, int $days = 30): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET blocked_until = DATE_ADD(NOW(), INTERVAL ? DAY) WHERE username = ?");
        $stmt->bind_param('is', $days, $username);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Activate (unsuspend) a user.
     * 
     * @param string $username Username to activate.
     * @return bool True if successful, false otherwise.
     */
    public function activate(string $username): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET blocked_until = NULL WHERE username = ?");
        $stmt->bind_param('s', $username);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Calculate monthly growth percentage.
     * 
     * @return int Growth percentage compared to last month.
     */
    public function getMonthlyGrowth(): int
    {
        $now = new DateTime();
        $thisMonthStart = $now->format('Y-m-01');
        $lastMonthStart = (new DateTime($now->format('Y-m-01') . ' -1 month'))->format('Y-m-01');
        $lastMonthEnd = (new DateTime($now->format('Y-m-01') . ' -1 day'))->format('Y-m-d');

        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) >= ?");
        $stmt->bind_param('s', $thisMonthStart);
        $stmt->execute();
        $thisMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
        $stmt->close();

        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?");
        $stmt->bind_param('ss', $lastMonthStart, $lastMonthEnd);
        $stmt->execute();
        $lastMonthCount = $stmt->get_result()->fetch_assoc()['count'] ?? 0;
        $stmt->close();

        return $lastMonthCount > 0 ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100) : 0;
    }
}
