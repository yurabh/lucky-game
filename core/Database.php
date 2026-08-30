<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config.php';
            $db = $config['db'];
            try {
                self::$pdo = new PDO(
                    "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}",
                    $db['username'],
                    $db['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Помилка підключення до БД: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
