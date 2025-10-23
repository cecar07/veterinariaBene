<?php
require_once __DIR__ . '/../config/database.php';

class Propietarios {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM propietarios ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM propietarios WHERE id_propietario = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $direccion = null, $telefono = null, $email = null) {
        $sql = "INSERT INTO propietarios (nombre, direccion, telefono, email) 
                VALUES (:nombre, :direccion, :telefono, :email)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email
        ]);
    }

    public function actualizar($id, $nombre, $direccion = null, $telefono = null, $email = null) {
        $sql = "UPDATE propietarios SET 
                    nombre = :nombre,
                    direccion = :direccion,
                    telefono = :telefono,
                    email = :email
                WHERE id_propietario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM propietarios WHERE id_propietario = :id");
        return $stmt->execute([':id' => $id]);
    }
}
