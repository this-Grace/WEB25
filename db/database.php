<?php

/**
 * DatabaseHelper class for managing MySQLi database connections and queries.
 * Provides a simple interface for database operations with prepared statements.
 */
class DatabaseHelper
{
    /**
     * @var mysqli The MySQLi database connection instance.
     */
    private $connection;

    /**
     * Constructor to initialize the database connection.
     *
     * @param string $host     The database host address.
     * @param string $db       The database name.
     * @param string $user     The database username.
     * @param string $password The database password.
     */
    public function __construct($host, $db, $user, $password)
    {
        $this->connection = new mysqli($host, $user, $password, $db);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    /**
     * Returns the current database connection instance.
     *
     * @return mysqli The MySQLi connection.
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Executes a raw SQL query (without prepared statements).
     *
     * @param string $sql The SQL query to execute.
     * @return mixed The query result.
     */
    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    /**
     * Prepares an SQL statement for execution.
     *
     * @param string $sql The SQL statement to prepare.
     * @return mysqli_stmt|false The prepared statement object.
     */
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    /**
     * Executes a SELECT query and returns the result set as an associative array.
     *
     * @param string $query  The SQL query string.
     * @param array  $params An array of parameters to bind.
     * @param string $types  A string of types corresponding to the parameters (e.g., 'ssi').
     * @return array The fetched data as an associative array, or an empty array on failure.
     */
    public function executeQuery($query, $params = [], $types = '')
    {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            die("Error in query preparation: " . $this->connection->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            $stmt->close();
            return [];
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    /**
     * Executes INSERT, UPDATE, or DELETE queries and returns success status.
     *
     * @param string $query  The SQL query string.
     * @param array  $params An array of parameters to bind.
     * @param string $types  A string of types corresponding to the parameters (e.g., 'ssi').
     * @return bool True on success, false on failure.
     */
    public function executeStatement($query, $params = [], $types = '')
    {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->connection->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Closes the database connection if it's open.
     */
    public function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    /**
     * Destructor ensures the database connection is closed when the object is destroyed.
     */
    public function __destruct()
    {
        $this->close();
    }
}
