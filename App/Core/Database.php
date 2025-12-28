<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (!self::$instance) {
            try {
                $host = $_ENV['DB_HOST'];
                $db   = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];

                self::$instance = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}