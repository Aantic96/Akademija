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
        $columns = [];
        $data = [];
        foreach ($values as $key => $value) {
            $columns[] = $key;
            $data[] = $value;
        }

        $query = "INSERT INTO $tableName(" . implode(', ', $columns) .
            ") VALUES(" . implode(', ', $data) . ")";

        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function groupInsert(string $tableName, array $values): void
    {
        if (!$this->isAssoc($values)) {
            echo "Wrong method";
            exit;
        }
        
        $columns = [];
        $data = [];
        foreach ($values as $value){
            $data[] = '(';
            foreach ($value as $k => $v){
                if(!in_array($columns))
                {
                    $columns[] = $k;
                }
                $data[] = $v;
            }
            $data[] = ')';
        }

        $query = "INSERT INTO $tableName(" . implode(', ', $columns) .
            ") VALUES(" . implode(', ', $data) . ")";

        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function isAssoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

    public function update(string $tableName, array $updateValues, array $condition)
    {
        //
    }
}