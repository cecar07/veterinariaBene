<?php
require_once __DIR__ . '/../models/Consulta.php';
require_once __DIR__ . '/../models/Mascota.php';
require_once __DIR__ . '/../models/Veterinario.php';

class ConsultaController
{
    private $modelConsulta;
    private $modelMascota;
    private $modelVeterinario;

    public function __construct()
    {
        $this->modelConsulta = new Consulta();
        $this->modelMascota = new Mascota();
        $this->modelVeterinario = new Veterinario();
    }

    // Listar consultas
    public function listar()
    {
        $consultas = $this->modelConsulta->obtenerTodos();
        include __DIR__ . '/../views/consultas/listar.php';
    }

    // Crear consulta
    public function crear()
    {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_mascota = $_POST['id_mascota'] ?? null;
            $id_veterinario = $_POST['id_veterinario'] ?? null;
            $fecha = $_POST['fecha'] ?? null;
            $hora = $_POST['hora'] ?? null;
            $motivo = $_POST['motivo'] ?? null;
            $diagnostico = $_POST['diagnostico'] ?? null;
            $tratamiento = $_POST['tratamiento'] ?? null;
            $observaciones = $_POST['observaciones'] ?? null;

            if (!$id_mascota || !$id_veterinario || !$fecha || !$hora) {
                $error = "Por favor complete los campos obligatorios.";
            } else {
                $this->modelConsulta->crear($id_mascota, $id_veterinario, $fecha, $hora, $motivo, $diagnostico, $tratamiento, $observaciones);
                header("Location: ?accion=listar");
                exit;
            }
        }
        $mascotas = $this->modelMascota->obtenerTodos();
        $veterinarios = $this->modelVeterinario->obtenerTodos();
        include __DIR__ . '/../views/consultas/crear.php';
    }

    // Editar consulta
    public function editar()
    {
        $error = "";
        if (!isset($_GET['id'])) {
            header("Location: ?accion=listar");
            exit;
        }
        $id = intval($_GET['id']);
        $consulta = $this->modelConsulta->obtenerPorId($id);
        if (!$consulta) {
            header("Location: ?accion=listar");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_mascota = $_POST['id_mascota'] ?? null;
            $id_veterinario = $_POST['id_veterinario'] ?? null;
            $fecha = $_POST['fecha'] ?? null;
            $hora = $_POST['hora'] ?? null;
            $motivo = $_POST['motivo'] ?? null;
            $diagnostico = $_POST['diagnostico'] ?? null;
            $tratamiento = $_POST['tratamiento'] ?? null;
            $observaciones = $_POST['observaciones'] ?? null;

            if (!$id_mascota || !$id_veterinario || !$fecha || !$hora) {
                $error = "Por favor complete los campos obligatorios.";
            } else {
                $this->modelConsulta->actualizar($id, $id_mascota, $id_veterinario, $fecha, $hora, $motivo, $diagnostico, $tratamiento, $observaciones);
                header("Location: ?accion=listar");
                exit;
            }
        }

        $mascotas = $this->modelMascota->obtenerTodos();
        $veterinarios = $this->modelVeterinario->obtenerTodos();
        include __DIR__ . '/../views/consultas/editar.php';
    }

    // Eliminar consulta
    public function eliminar($id)
    {
        if (!$id) {
            header("Location: ?accion=listar");
            exit;
        }
        $this->modelConsulta->eliminar($id);
        header("Location: ?accion=listar");
        exit;
    }
} // Enrutador de acciones
if (isset($_GET['accion'])) {
    $controlador = new ConsultaController();

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
            if (isset($_GET['id'])) {
                $controlador->eliminar($_GET['id']);
            }
            break;
        default:
            echo "Acción no válida.";
            break;
    }
}
