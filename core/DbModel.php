<?php namespace app\core;

use app\core\Application;
use Iterator;

abstract class DbModel extends Model
{

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attrs = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attrs);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attrs) . ") VALUES (" . implode(',', $params) . ")");
        foreach ($attrs as $attr) {
            $statement->bindValue(":$attr", $this->{$attr});
        }
        $statement->execute();
        return true;
    }

    public function findOneRow(array $where)
    {
        $tableName = $this->tableName();
        $keys = array_keys($where);
        $sql = implode(' AND ', array_map(fn($key) => "$key=:$key", $keys));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql ");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare(string $sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }


}