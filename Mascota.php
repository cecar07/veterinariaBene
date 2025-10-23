<?php
require_once __DIR__ . '/../config/database.php';

class Mascota
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function obtenerTodos()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM mascotas ORDER BY nombre");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Loguea el error o maneja la excepción según necesidad
            return [];
        }
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM mascotas WHERE id_mascota = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $especie = null, $raza = null, $edad = null, $sexo = null, $id_propietario)
    {
        if (!$nombre || !$id_propietario) {
            throw new InvalidArgumentException("Nombre e id_propietario son obligatorios");
        }
        $sql = "INSERT INTO mascotas (nombre, especie, raza, edad, sexo, id_propietario) 
                VALUES (:nombre, :especie, :raza, :edad, :sexo, :id_propietario)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':especie' => $especie,
            ':raza' => $raza,
            ':edad' => $edad,
            ':sexo' => $sexo,
            ':id_propietario' => $id_propietario
        ]);
    }

    public function actualizar($id, $nombre, $especie = null, $raza = null, $edad = null, $sexo = null, $id_propietario)
    {
        if (!$id || !$nombre || !$id_propietario) {
            throw new InvalidArgumentException("ID, nombre e id_propietario son obligatorios");
        }
        $sql = "UPDATE mascotas SET 
                    nombre = :nombre,
                    especie = :especie,
                    raza = :raza,
                    edad = :edad,
                    sexo = :sexo,
                    id_propietario = :id_propietario
                WHERE id_mascota = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':especie' => $especie,
            ':raza' => $raza,
            ':edad' => $edad,
            ':sexo' => $sexo,
            ':id_propietario' => $id_propietario
        ]);
    }

    public function eliminar($id)
    {
        if (!$id) {
            throw new InvalidArgumentException("ID no válido");
        }
        $stmt = $this->pdo->prepare("DELETE FROM mascotas WHERE id_mascota = :id");
        return $stmt->execute([':id' => $id]);
    }
}
