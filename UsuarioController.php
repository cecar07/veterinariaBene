<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new Usuario();
    }

    public function listar() {
        $usuarios = $this->model->obtenerTodos();
        include __DIR__ . '/../views/admin/usuarios/listar.php';
    }

    public function crear() {
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"] ?? '';
            $usuario = $_POST["usuario"] ?? '';
            $contrasena = $_POST["contrasena"] ?? '';
            $rol = $_POST["rol"] ?? '';

            if (empty($nombre) || empty($usuario) || empty($contrasena) || empty($rol)) {
                $error = "Por favor complete todos los campos.";
            } else {
                $this->model->crear($nombre, $usuario, $contrasena, $rol);
                header("Location: listar.php");
                exit;
            }
        }
        include __DIR__ . '/../views/admin/usuarios/crear.php';
    }

    public function editar() {
        $error = "";
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: listar.php");
            exit;
        }
        $id = intval($_GET['id']);
        $usuario = $this->model->obtenerPorId($id);

        if (!$usuario) {
            header("Location: listar.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"] ?? '';
            $usuario_nuevo = $_POST["usuario"] ?? '';
            $rol = $_POST["rol"] ?? '';
            $contrasena = $_POST["contrasena"] ?? null;

            if (empty($nombre) || empty($usuario_nuevo) || empty($rol)) {
                $error = "Por favor complete todos los campos.";
            } else {
                $this->model->actualizar($id, $nombre, $usuario_nuevo, $rol, $contrasena ?: null);
                header("Location: listar.php");
                exit;
            }
        }

        include __DIR__ . '/../views/admin/usuarios/editar.php';
    }

    public function eliminar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: listar.php");
            exit;
        }
        $id = intval($_GET['id']);
        $this->model->eliminar($id);
        header("Location: listar.php");
        exit;
    }

    public function login() {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($usuario) || empty($contrasena)) {
        $_SESSION['error'] = "Por favor complete todos los campos.";
        header("Location: login.php");
        exit;
    }

    $usuarioData = $this->model->verificarLogin($usuario, $contrasena);

    if ($usuarioData) {
        $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
        $_SESSION['nombre'] = $usuarioData['nombre'];
        $_SESSION['rol'] = $usuarioData['rol'];

        // Redirigir según el rol
        switch ($_SESSION['rol']) {
            case 'admin':
                header("Location: views/admin/dashboard.php");
                break;
            case 'veterinario':
                header("Location: views/veterinario/dashboard.php");
                break;
            case 'recepcionista':
                header("Location: views/recepcionista/dashboard.php");
                break;
        }
        exit;
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit;
    }
}

}
