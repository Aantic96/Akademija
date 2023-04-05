<?php

namespace App;

use PDO;

class Connection
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        //TODO: Make dynamic
        $db = "phpframework";
        $host = "localhost";
        $pw = "12345";
        $user = "nela";

        $this->connection = new PDO("mysql:host=$host;dbname=$db", $user, $pw);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            return self::$instance = new Connection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function fetchAssoc(string $query, array $values)
    {
        $statement = $this->connection->prepare($query);

        $statement->execute($values);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(string $query, array $values, ?int $limit)
    {
        if ($limit) {
            $query .= " LIMIT $limit";
        }

        $statement = $this->connection->prepare($query);
        $statement->execute($values);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $tableName, array $addValues)
    {
        //
    }

    public function update(string $tableName, array $updateValues, array $condition)
    {
        //
    }
}