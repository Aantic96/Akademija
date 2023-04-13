<?php

namespace Core;

use Core\Traits\HasTimestamps;
use Core\Traits\SoftDelete;
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

    public static function find($primaryKey): object
    {
        $tableName = self::getTableName();

        $query = "SELECT * FROM " . $tableName . " WHERE " .
            self::$primaryKeyColumn . '=:primary_key';

        if (in_array(SoftDelete::class, class_uses(static::class))) {
            $query .= " AND deleted_at IS NULL";
        }

        $instance = new static();
        $instance->attributes = Connection::getInstance()
            ->fetchAssoc($query, ['primary_key' => $primaryKey]);

        return $instance;
    }

    public function save(): object
    {
        if (in_array(HasTimestamps::class, class_uses($this))) {
            $this->setCreatedTimestamps();
        }

        Connection::getInstance()->insert(self::getTableName(), $this->attributes);
        $this->{self::$primaryKeyColumn} =
            Connection::getInstance()->getConnection()->lastInsertId(self::$primaryKeyColumn);

        return $this;
    }

    public function update(): object
    {
        if (in_array(HasTimestamps::class, class_uses($this))) {
            $this->setUpdatedTimestamps();
        }

        Connection::getInstance()->update(self::getTableName(), $this->attributes, [[
            'value' => $this->attributes[self::$primaryKeyColumn],
            'column' => self::$primaryKeyColumn,
            'operator' => '='
        ]]);

        return $this;
    }

    public function delete(): object
    {
        if (in_array(SoftDelete::class, class_uses($this))) {
            $this->softDelete();
            $this->update();
        } else {
            Connection::getInstance()->delete(self::getTableName(), [[
                'value' => $this->attributes[self::$primaryKeyColumn],
                'column' => self::$primaryKeyColumn,
                'operator' => '='
            ]]);
        }
        
        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public static function getTableName(): string
    {
        if (isset(static::$tableName)) {
            return static::$tableName;
        }

        $word = self::getNameOfClass();
        $inflector = InflectorFactory::create()->build();
        return $inflector->pluralize($inflector->tableize($word));
    }
}