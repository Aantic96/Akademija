<?php

namespace Core;

use Dotenv\Dotenv;
use PDO;

$dotenv = Dotenv::createImmutable("/var/www/html/phpframework");
$dotenv->load();

class Connection
{
    private static ?Connection $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $db = $_ENV['DB_NAME'];
        $host = $_ENV['DB_HOST'];
        $pw = $_ENV['DB_PASSWORD'];
        $user = $_ENV['DB_USER'];

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
        if (!empty($values) && array_key_exists(0, $values) && is_array($values[0])) {
            $columns = array_keys($values[0]);
            foreach ($values as $entry) {
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

    public function update(string $tableName, array $values, array $conditions):void
    {
        $data = [];
        foreach ($values as $column => $value) {
            $data[] = "$column = '$value'";
        }

        $where = [];
        foreach ($conditions as $condition) {
            $boolOperator = empty($where) ? "WHERE " : $condition['bool_operator'] . " ";
            $where[] = $boolOperator . $condition['column'] . $condition['operator'] . "'" .
                $condition['value'] . "'";
        }

        $query = "UPDATE $tableName SET " . implode(", ", $data) . implode(' ', $where);
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }
}