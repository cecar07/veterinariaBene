<?php
require_once __DIR__ . '/../config/database.php';

class Veterinario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public static function obtenerTodos()
    {
        $pdo = Database::connect();
        $sql = "SELECT v.*, u.nombre FROM veterinarios v 
            JOIN usuarios u ON v.id_usuario = u.id_usuario 
            ORDER BY u.nombre";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerPorId($id)
    {
        $sql = "SELECT v.*, u.nombre FROM veterinarios v 
                JOIN usuarios u ON v.id_usuario = u.id_usuario 
                WHERE v.id_veterinario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($id_usuario, $especialidad = null)
    {
        if (!$id_usuario) {
            throw new InvalidArgumentException("ID de usuario es obligatorio");
        }
        $sql = "INSERT INTO veterinarios (id_usuario, especialidad) VALUES (:id_usuario, :especialidad)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':especialidad' => $especialidad
        ]);
    }

    public function actualizar($id, $id_usuario, $especialidad = null)
    {
        if (!$id || !$id_usuario) {
            throw new InvalidArgumentException("ID y id_usuario son obligatorios");
        }
        $sql = "UPDATE veterinarios SET id_usuario = :id_usuario, especialidad = :especialidad WHERE id_veterinario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_usuario' => $id_usuario,
            ':especialidad' => $especialidad
        ]);
    }

    public function eliminar($id)
    {
        if (!$id) {
            throw new InvalidArgumentException("ID no válido");
        }
        $stmt = $this->pdo->prepare("DELETE FROM veterinarios WHERE id_veterinario = :id");
        return $stmt->execute([':id' => $id]);
    }
}
