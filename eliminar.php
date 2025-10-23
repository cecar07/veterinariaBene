<?php
require_once '../../config/Database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = intval($_GET['id']);

$pdo = Database::connect();

// Eliminar usuario
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);

header("Location: listar.php");
exit;
