<?php


namespace bookstore\repository;


use mysqli;
use PDO;

/**
 * Class Connection
 * @package bookstore\repository
 */
class Connection
{
    protected static $connection;

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

        self::$connection = new PDO('mysql:dbname=bookstore;host=mysqldb', 'root', 'p@ssw0rd1');

        return self::$connection;
    }
}