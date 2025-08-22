<?php

require_once 'src/lib/param.php';

class DatabaseManager
{
    public static function listDatabases(): array
    {
        try {
            $pdo = new PDO("mysql:host=$GLOBALS[host];charset=utf8", $GLOBALS['user'], $GLOBALS['pwd']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SHOW DATABASES");
            $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);

            return array_filter($databases, fn($db) => !in_array($db, [
                'information_schema', 'mysql', 'performance_schema', 'sys'
            ]));
        } catch (Exception $e) {
            return [];
        }
    }
}
