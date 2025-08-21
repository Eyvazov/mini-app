<?php

namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdo = null;

    public static function pdo(array $cfg): PDO
    {
        if (!self::$pdo) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $cfg['db']['host'], $cfg['db']['name'], $cfg['db']['charset']);
            self::$pdo = new PDO($dsn, $cfg['db']['user'], $cfg['db']['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$pdo;
    }
}