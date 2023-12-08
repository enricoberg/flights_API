<?php
namespace App\Core;

class Database{
    public static function connection() {

        $envFile = __DIR__ . '/../.env';
        $env = file_get_contents($envFile);    
        $envVariables = [];
        foreach (explode("\n", $env) as $line) {
            $line = trim($line);
            if ($line && strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $envVariables[$key] = $value;
            }
        }
    
        
        $servername = $envVariables['DB_HOST'];
        $dbname = $envVariables['DB_NAME'];
        $username = $envVariables['DB_USER'];
        $password = $envVariables['DB_PASS'];
        
    
        try {
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            return $conn;
        } catch(\PDOException $e) {
            echo "Connection to DB failed: " . $e->getMessage();
            return null; 
        }
    }
}







?>