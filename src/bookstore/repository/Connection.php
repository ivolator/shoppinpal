<?php


namespace bookstore\repository;


use PDO;

/**
 * Class Connection
 * @package bookstore\repository
 */
class Connection
{
    protected static $connection;

    protected $db;
    protected $host;
    protected $username;
    protected $password;

    public function __construct($db, $host, $username, $password)
    {
        $this->db = $db;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Needs to have arguments passed for DB connection instead of hardcoding them
     *
     * Singelton conmnection
     * @return PDO
     */
    public function getConnection(): PDO
    {
        if (self::$connection) {
            return self::$connection;
        }

        $dsn = 'mysql:dbname=' . $this->db . ';host=' . $this->host;
        self::$connection = new PDO($dsn, $this->username, $this->password);

        return self::$connection;
    }
}