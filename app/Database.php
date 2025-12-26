<?php

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';

        $host = $config['host'] ?? '127.0.0.1';
        $user = $config['user'] ?? '';
        $pass = $config['pass'] ?? '';
        $dbname = $config['dbname'] ?? '';
        $port = isset($config['port']) ? (int)$config['port'] : 3306;
        $charset = $config['charset'] ?? 'utf8mb4';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $this->conn = new mysqli($host, $user, $pass, $dbname, $port);
        if ($this->conn->connect_errno) {
            throw new Exception('MySQL connection error: ' . $this->conn->connect_error);
        }

        if (!empty($charset)) {
            $this->conn->set_charset($charset);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->conn;
    }
}
