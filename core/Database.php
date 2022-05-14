<?php namespace app\core;

use PDO;
use app\migrations\m01_initial;


class Database
{

    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $pass = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $migrations = scandir(dirname(__DIR__) . '/migrations');
        $toAppliedMigration = array_diff($migrations, $appliedMigrations);

        $newArr = array();

        foreach ($toAppliedMigration as $migration) {
            if ($migration === "." || $migration === "..") {
                continue;
            }

            require_once dirname(__DIR__) . "/migrations/$migration";
            $className = "app\migrations\\" . pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();
            $instance->up();
            $newArr[] = $migration;
        }

        if (!empty($newArr)) {
            $this->saveMigration($newArr);
        }
//        else echo "All migration are applied";

    }

    public function createMigrationTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) ,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )ENGINE=INNODB;");
    }

    public function getAppliedMigrations(): array
    {
        $result = $this->pdo->prepare("SELECT migration FROM migrations");
        $result->execute();
        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigration(array $arr): void
    {

        $arr = implode(',', array_map(fn($m) => "('$m')", $arr));

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUE $arr");
        $statement->execute();
    }

}