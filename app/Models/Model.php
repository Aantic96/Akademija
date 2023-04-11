<?php

namespace App\Models;

use App\Connection;
use Doctrine\Inflector\InflectorFactory;

abstract class Model
{
    protected static string $primaryKeyColumn = 'id';
    protected static string $tableName;
    protected array $attributes = [];

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get(string $key)
    {
        return $this->attributes[$key];
    }

    public static function getNameOfClass(): string
    {
        if (str_contains(static::class, "\\")) {
            $name = explode("\\", static::class);
            return end($name);
        }

        return static::class;
    }

    private static function getTableName(): string
    {
        if (isset(static::$tableName)) {
            return static::$tableName;
        }

        $word = self::getNameOfClass();
        $inflector = InflectorFactory::create()->build();
        return $inflector->pluralize($inflector->tableize($word));
    }

    private static function getPrimaryKeyColumn(): string
    {
        return static::$primaryKeyColumn;
    }

    public static function find($primaryKey)
    {
        $primaryKeyColumn = self::getPrimaryKeyColumn();
        $tableName = self::getTableName();

        $instance = new static();
        $instance->attributes = Connection::getInstance()
            ->fetchAssoc("SELECT * FROM " . $tableName . " WHERE " .
                $primaryKeyColumn . '=:primary_key',
                ['primary_key' => $primaryKey]);

        return $instance;
    }

    protected function save()
    {

    }

    protected function update()
    {

    }

    public function toArray(): array
    {
        return $this->attributes;
    }

}