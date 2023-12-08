<?php

namespace App\Core;

use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

class Database
{
    public static function connection()
    {
        $servername = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        try {
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            return $conn;
        } catch (\PDOException $e) {
            echo "Connection to DB failed: " . $e->getMessage();
            return null;
        }
    }
}
