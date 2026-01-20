<?php

/**
 * Database connection handler using Singleton pattern.
 * 
 * This class provides a single database connection instance throughout the application.
 * It uses MySQLi for database operations and follows the Singleton design pattern
 * to ensure only one database connection exists.
 */
class Database
{
    /**
     * @var Database|null The single instance of the Database class.
     */
    private static $instance = null;

    /**
     * @var mysqli The database connection object.
     */
    private $conn;

    /**
     * Private constructor to prevent direct instantiation.
     * 
     * Reads database configuration and establishes a MySQLi connection.
     * 
     * @throws Exception If database connection fails.
     */
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

    /**
     * Get the single instance of the Database class.
     * 
     * @return mysqli The MySQLi database connection object.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->conn;
    }
}
