<?php
require_once '../../config/Database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = intval($_GET['id']);
$error = "";

$pdo = Database::connect();

// Obtener datos actuales del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: listar.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $usuario_nuevo = $_POST["usuario"];
    $rol = $_POST["rol"];

    // Si se quiere cambiar contraseña, si está vacía no se actualiza
    if (!empty($_POST["contrasena"])) {
        $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, contrasena = ?, rol = ? WHERE id_usuario = ?");
        $stmt->execute([$nombre, $usuario_nuevo, $contrasena, $rol, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, rol = ? WHERE id_usuario = ?");
        $stmt->execute([$nombre, $usuario_nuevo, $rol, $id]);
    }

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Usuario</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Contraseña (dejar vacío para no cambiar)</label>
            <input type="password" name="contrasena" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="rol" class="form-select" required>
                <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                <option value="veterinario" <?= $usuario['rol'] == 'veterinario' ? 'selected' : '' ?>>Veterinario</option>
                <option value="recepcionista" <?= $usuario['rol'] == 'recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
