<?php

/**
 * Simple User data mapper for the USERS table.
 * Provides basic CRUD and authentication helpers using mysqli prepared statements.
 */
class User
{
    private $conn; // mysqli connection

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Find a user by email. Returns associative array or null.
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
     * Check existence by email.
     */
    public function exists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    /**
     * Create a new user. $password is plain text and will be hashed.
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
     * Verify credentials; returns user data on success or null on failure.
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;
        $hash = $user['password'] ?? null;
        if ($hash && password_verify($password, $hash)) {
            // do not expose password hash
            unset($user['password']);
            return $user;
        }
        return null;
    }

    /**
     * Update user's password (hashes the new password).
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
     * Delete a user by email.
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
