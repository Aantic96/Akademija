<?php

namespace App\Models;

use App\Connection;
use Doctrine\Inflector\InflectorFactory;

abstract class Model
{
    protected static string $primaryKeyColumn = 'id';
    protected static string $tableName;

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

        return Connection::getInstance()
            ->fetchAssoc("SELECT * FROM " . $tableName . " WHERE " .
                $primaryKeyColumn . '=:primary_key',
                ['primary_key' => $primaryKey]);
    }

    protected function save()
    {

    }

    protected function update()
    {

    }

    protected function toArray()
    {

    }

}