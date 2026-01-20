<?php

class DatabaseHelper
{
    private $db;

    /**
     * Constructor to initialize database connection.
     * 
     * @param string $servername The database server name
     * @param string $username The database username
     * @param string $password The database password
     * @param string $dbname The database name
     * @param int $port The database port
     * @param string $charset The character set
     */
    public function __construct($servername, $username, $password, $dbname, $port = 3306, $charset = 'utf8mb4')
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
        $this->db->set_charset($charset);
    }

    /**
     * Execute a query and return the result.
     * 
     * @param string $sql The SQL query
     * @return mysqli_result|bool The result of the query
     */
    public function query($sql)
    {
        return $this->db->query($sql);
    }

    /**
     * Prepare and execute a statement with parameters.
     * 
     * @param string $sql The SQL query with placeholders
     * @param array $params The parameters to bind
     * @return mysqli_stmt|bool The prepared statement
     */
    public function prepare($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $types = $this->inferTypes($params);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
        }
        return $stmt;
    }

    /**
     * Fetch a single row as an associative array.
     * 
     * @param mysqli_result $result The result set
     * @return array|null The row or null if none
     */
    public function fetch($result)
    {
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Fetch all rows as an array of associative arrays.
     * 
     * @param mysqli_result $result The result set
     * @return array The rows
     */
    public function fetchAll($result)
    {
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * Get the last insert ID.
     * 
     * @return int The last insert ID
     */
    public function getLastInsertId()
    {
        return $this->db->insert_id;
    }

    /**
     * Escape a string for safe SQL use.
     * 
     * @param string $string The string to escape
     * @return string The escaped string
     */
    public function escape($string)
    {
        return $this->db->real_escape_string($string);
    }

    /**
     * Close the database connection.
     */
    public function close()
    {
        if ($this->db) {
            $this->db->close();
        }
    }

    /**
     * Get the database connection object.
     * 
     * @return mysqli The database connection
     */
    public function getConnection()
    {
        return $this->db;
    }

    /**
     * Infer parameter types for bind_param.
     * 
     * @param array $params The parameters
     * @return string Type string (s, i, d, b)
     */
    private function inferTypes($params)
    {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }
}
