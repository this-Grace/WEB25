<?php

require_once __DIR__ . '/Database.php';

class User
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $result = mysqli_query($this->db, "SELECT username, email, bio, avatar_url, created_at FROM users");
        if ($result === false) return [];
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $rows;
    }

    public function find($username)
    {
        $stmt = mysqli_prepare($this->db, "SELECT username, email, bio, avatar_url, created_at FROM users WHERE username = ? LIMIT 1");
        if ($stmt === false) return null;
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = $res ? mysqli_fetch_assoc($res) : null;
        if ($res) mysqli_free_result($res);
        mysqli_stmt_close($stmt);
        return $row;
    }
}
