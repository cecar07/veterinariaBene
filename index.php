<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: /veterinaria/index.php");
    exit;
}


switch ($_SESSION['rol']) {
    case 'admin':
        $vista = __DIR__ . '/views/admin/index.php';
        break;
    case 'veterinario':
        $vista = __DIR__ . '/views/veterinario/index.php';
        break;
    case 'recepcionista':
        $vista = __DIR__ . '/views/recepcionista/index.php';
        break;
    default:
        die("Rol no reconocido.");
}

if (!file_exists($vista)) {
    die("Error: Archivo no encontrado para el rol en la ruta: $vista");
}

include $vista;
