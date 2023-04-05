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

    public function insert(string $tableName, array $values): void
    {
        $data = [];
        if (!empty($values) && is_array($values[0])) {
            $columns = array_keys($values[0]);
            foreach ($values as $entry) {
                var_dump($entry);
                $data[] = "('" . implode("', '", $entry) . "')";
            }
        } else {
            $columns = array_keys($values);
            $data[] = "('" . implode("', '", $values) . "')";
        }

        $query = "INSERT INTO $tableName(" . implode(', ', $columns) .
            ") VALUES" . implode(', ', $data);

        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function update(string $tableName, array $values, array $conditions)
    {
        $data = [];
        foreach ($values as $column => $value) {
            $data[] = "$column = '$value'";
        }
        //TODO: Add other conditions (?)
        $where = "";
        foreach ($conditions as $key => $value) {
            $where = " WHERE $key = '$value'";
        }

        $query = "UPDATE $tableName SET " . implode(", ", $data) . $where;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }
}