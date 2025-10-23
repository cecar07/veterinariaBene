<?php
class Database {
    public static function connect() {
        $host = 'localhost';
        $dbname = 'veterinaria';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión a BD: " . $e->getMessage());
        }
    }
}
