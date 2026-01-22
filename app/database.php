<?php

/**
 * DatabaseHelper Class
 * A simple MySQLi database connection wrapper with charset configuration.
 */
class DatabaseHelper
{
    /**
     * @var mysqli $db MySQLi database connection instance
     */
    private $db;

    /**
     * Constructor - Establishes a MySQLi database connection
     * 
     * @param string $servername Database server hostname
     * @param string $username Database username
     * @param string $password Database password
     * @param string $dbname Database name
     * @param int $port Database port (default: 3306)
     * @param string $charset Connection charset (default: 'utf8mb4')
     * 
     * @throws Exception If connection fails, script terminates with error message
     */
    public function __construct($servername, $username, $password, $dbname, $port, $charset)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
        $this->db->set_charset($charset);
    }

    /**
     * Returns the MySQLi connection instance
     * 
     * @return mysqli MySQLi database connection
     */
    public function getConnection()
    {
        return $this->db;
    }
}
