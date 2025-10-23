<?php
class DashboardController {
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: /veterinaria/login.php');
            exit;
        }

        $rol = $_SESSION['rol'];

        switch ($rol) {
            case 'admin':
                require_once(__DIR__ . '/../views/admin/index.php');
                break;
            case 'veterinario':
                require_once(__DIR__ . '/../views/veterinario/index.php');
                break;
            case 'recepcionista':
                require_once(__DIR__ . '/../views/recepcionista/index.php');
                break;
            default:
                echo "Rol no reconocido.";
                break;
        }
    }
}
