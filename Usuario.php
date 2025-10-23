<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM usuarios ORDER BY id_usuario DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $usuario, $contrasena, $rol)
    {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, usuario, contrasena, rol) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $usuario, $hash, $rol]);
    }

    public function actualizar($id, $nombre, $usuario, $rol, $contrasena = null)
    {
        if ($contrasena) {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, contrasena = ?, rol = ? WHERE id_usuario = ?");
            return $stmt->execute([$nombre, $usuario, $hash, $rol, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, rol = ? WHERE id_usuario = ?");
            return $stmt->execute([$nombre, $usuario, $rol, $id]);
        }
    }

    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

    public static function verificarLogin($usuario, $contrasena)
    {
        $db = Database::connect();
        $query = "SELECT * FROM usuarios WHERE usuario = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute([$usuario]);

        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($contrasena, $usuarioData['contrasena'])) {
            return $usuarioData;
        }

        return false;
    }
}
