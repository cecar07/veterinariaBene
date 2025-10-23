<?php
require_once __DIR__ . '/../models/Propietario.php';

class PropietarioController
{
    private $model;

    public function __construct()
    {
        $this->model = new Propietarios();
    }

    public function listar()
    {
        $propietarios = $this->model->obtenerTodos();
        //var_dump($propietarios);  // <-- línea de prueba
        include __DIR__ . '/../views/propietarios/listar.php';
    }

    public function crear()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!$nombre) {
                $error = "El nombre es obligatorio.";
            } else {
                $this->model->crear($nombre, $direccion ?: null, $telefono ?: null, $email ?: null);
                header("Location: ?accion=listar");
                exit;
            }
        }
        include __DIR__ . '/../views/propietarios/crear.php';
    }

    public function editar()
    {
        $error = '';
        if (!isset($_GET['id'])) {
            header("Location: ?accion=listar");
            exit;
        }

        $id = intval($_GET['id']);
        $propietario = $this->model->obtenerPorId($id);
        if (!$propietario) {
            header("Location: ?accion=listar");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!$nombre) {
                $error = "El nombre es obligatorio.";
            } else {
                $this->model->actualizar($id, $nombre, $direccion ?: null, $telefono ?: null, $email ?: null);
                header("Location: ?accion=listar");
                exit;
            }
        }

        include __DIR__ . '/../views/propietarios/editar.php';
    }

    public function eliminar()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?accion=listar");
            exit;
        }
        $id = intval($_GET['id']);
        $this->model->eliminar($id);
        header("Location: ?accion=listar");
        exit;
    }
}

if (isset($_GET['accion'])) {
    $controlador = new PropietarioController();

    switch ($_GET['accion']) {
        case 'listar':
            $controlador->listar();
            break;
        case 'crear':
            $controlador->crear();
            break;
        case 'editar':
            $controlador->editar();
            break;
        case 'eliminar':
            $controlador->eliminar();
            break;
        default:
            echo "Acción no válida.";
    }
}
