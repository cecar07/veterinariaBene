<?php
require_once __DIR__ . '/../config/database.php';

class Consulta {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public static function contar() {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->query("SELECT COUNT(*) FROM consultas");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            // Aquí podrías loggear el error en un archivo o base de datos
            return 0;
        }
    }

    // Crear nueva consulta con validación básica
    public function crear($id_mascota, $id_veterinario, $fecha, $hora, $motivo = null, $diagnostico = null, $tratamiento = null, $observaciones = null) {
        if (!$id_mascota || !$id_veterinario || !$fecha || !$hora) {
            throw new InvalidArgumentException("Campos obligatorios incompletos");
        }

        $sql = "INSERT INTO consultas 
                (id_mascota, id_veterinario, fecha, hora, motivo, diagnostico, tratamiento, observaciones) 
                VALUES 
                (:id_mascota, :id_veterinario, :fecha, :hora, :motivo, :diagnostico, :tratamiento, :observaciones)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_mascota' => $id_mascota,
            ':id_veterinario' => $id_veterinario,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':motivo' => $motivo,
            ':diagnostico' => $diagnostico,
            ':tratamiento' => $tratamiento,
            ':observaciones' => $observaciones
        ]);
    }

    public function obtenerTodos() {
        $sql = "SELECT c.*, 
                       m.nombre AS nombre_mascota, 
                       v.id_veterinario,
                       u.nombre AS nombre_veterinario
                FROM consultas c
                JOIN mascotas m ON c.id_mascota = m.id_mascota
                JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
                JOIN usuarios u ON v.id_usuario = u.id_usuario
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT c.*, 
                       m.nombre AS nombre_mascota, 
                       v.id_veterinario,
                       u.nombre AS nombre_veterinario
                FROM consultas c
                JOIN mascotas m ON c.id_mascota = m.id_mascota
                JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
                JOIN usuarios u ON v.id_usuario = u.id_usuario
                WHERE c.id_consulta = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $id_mascota, $id_veterinario, $fecha, $hora, $motivo = null, $diagnostico = null, $tratamiento = null, $observaciones = null) {
        if (!$id || !$id_mascota || !$id_veterinario || !$fecha || !$hora) {
            throw new InvalidArgumentException("Campos obligatorios incompletos");
        }

        $sql = "UPDATE consultas SET 
                    id_mascota = :id_mascota,
                    id_veterinario = :id_veterinario,
                    fecha = :fecha,
                    hora = :hora,
                    motivo = :motivo,
                    diagnostico = :diagnostico,
                    tratamiento = :tratamiento,
                    observaciones = :observaciones
                WHERE id_consulta = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':id_mascota' => $id_mascota,
            ':id_veterinario' => $id_veterinario,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':motivo' => $motivo,
            ':diagnostico' => $diagnostico,
            ':tratamiento' => $tratamiento,
            ':observaciones' => $observaciones
        ]);
    }

    public function eliminar($id) {
        if (!$id) {
            throw new InvalidArgumentException("ID no válido");
        }

        $sql = "DELETE FROM consultas WHERE id_consulta = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
