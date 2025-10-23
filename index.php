<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
        }
        nav {
            min-height: 100vh;
        }
        iframe {
            width: 100%;
            height: 85vh;
            border: none;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Menú lateral -->
    <nav class="bg-dark text-white p-3" style="width: 250px;">
        <h4 class="text-center">Administrador</h4>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php">🏠 Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../views/admin/listar.php" target="contenido">👤 Gestionar Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../views/mascotas/listar.php" target="contenido">🐾 Gestionar Mascotas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../views/tratamientos/listar.php" target="contenido">💊 Gestionar Tratamientos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../controllers/ConsultaController.php?accion=listar" target="contenido">🩺 Gestionar Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../views/propietarios/listar.php" target="contenido">📋 Listar Propietarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../../views/veterinario/listar.php" target="contenido">👨‍⚕️ Listar Veterinarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="/veterinaria/logout.php">🚪 Cerrar Sesión</a>
            </li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="p-4 flex-grow-1">
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h2>
        <p class="text-muted">Tienes acceso completo al sistema como <strong>administrador</strong>.</p>

        <!-- Contenedor dinámico -->
        <iframe name="contenido"></iframe>
    </main>
</div>
</body>
</html>
