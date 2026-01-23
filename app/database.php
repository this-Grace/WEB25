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

    /**
     * Execute a raw query (SELECT) and return the result set or false on failure.
     * Prefer prepared statements for user-supplied input.
     *
     * @param string $sql
     * @return mysqli_result|false
     */
    public function query(string $sql)
    {
        return $this->db->query($sql);
    }

    /**
     * Execute a raw non-SELECT query (INSERT/UPDATE/DELETE). Returns boolean.
     *
     * @param string $sql
     * @return bool
     */
    public function execute(string $sql): bool
    {
        return (bool)$this->db->query($sql);
    }

    /**
     * Prepare and execute a statement with the given parameters.
     * The parameter types are inferred automatically (i -> integer, d -> double, s -> string, b -> blob).
     * Returns mysqli_result for SELECT or boolean for write queries. Returns false on failure.
     *
     * @param string $sql
     * @param array $params
     * @return mysqli_result|bool|false
     */
    public function prepareAndExecute(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        if (!empty($params)) {
            $types = $this->getParamTypes($params);
            // bind_param requires parameters passed by reference
            $bindParams = [];
            $bindParams[] = $types;
            // create references to the params in the original array
            foreach ($params as $key => $value) {
                $bindParams[] = &$params[$key];
            }
            // @phpstan-ignore-next-line dynamic call to bind_param
            if (!call_user_func_array([$stmt, 'bind_param'], $bindParams)) {
                $stmt->close();
                return false;
            }
        }

        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }

        $result = $stmt->get_result();
        if ($result !== false && $result !== null) {
            // SELECT-like: return mysqli_result
            $stmt->close();
            return $result;
        }

        // For non-SELECT statements, return boolean success
        $ok = $stmt->affected_rows !== null ? ($stmt->affected_rows >= 0) : true;
        $stmt->close();
        return $ok;
    }

    /**
     * Get the last insert id for the connection.
     *
     * @return int|string
     */
    public function lastInsertId()
    {
        return $this->db->insert_id;
    }

    /**
     * Get the number of affected rows from the last operation on the connection.
     *
     * @return int
     */
    public function affectedRows(): int
    {
        return $this->db->affected_rows;
    }

    /**
     * Infer mysqli bind_param types from PHP values.
     *
     * @param array $params
     * @return string
     */
    private function getParamTypes(array $params): string
    {
        $types = '';
        foreach ($params as $p) {
            if (is_int($p)) $types .= 'i';
            elseif (is_float($p) || is_double($p)) $types .= 'd';
            elseif (is_null($p)) $types .= 's';
            elseif (is_string($p)) $types .= 's';
            else $types .= 'b';
        }
        return $types;
    }
}
