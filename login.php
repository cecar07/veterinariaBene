<?php
session_start();
require_once 'config/Database.php';

if (isset($_SESSION['usuario'])) {
    // Redireccionar al index correspondiente si ya está logueado
    switch ($_SESSION['rol']) {
        case 'admin':
            header("Location: admin/index.php");
            break;
        case 'veterinario':
            header("Location: veterinario/index.php");
            break;
        case 'recepcionista':
            header("Location: recepcionista/index.php");
            break;
        default:
            header("Location: login.php");
    }
    exit;
}

$usuario = $contrasena = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["usuario"]))) {
        $error = "Por favor, ingrese su usuario.";
    } else {
        $usuario = trim($_POST["usuario"]);
    }

    if (empty(trim($_POST["contrasena"]))) {
        $error = "Por favor, ingrese su contraseña.";
    } else {
        $contrasena = trim($_POST["contrasena"]);
    }

    if (empty($error)) {
        try {
            $pdo = Database::connect();

            $stmt = $pdo->prepare("SELECT id_usuario, nombre, usuario, contrasena, rol FROM usuarios WHERE usuario = :usuario LIMIT 1");
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($contrasena, $fila['contrasena'])) {
                    $_SESSION['id_usuario'] = $fila['id_usuario'];
                    $_SESSION['usuario'] = $fila['usuario'];
                    $_SESSION['nombre'] = $fila['nombre'];
                    $_SESSION['rol'] = $fila['rol'];

                    // Redirigir según el rol del usuario
                    switch ($fila['rol']) {
                        case 'admin':
                            header("Location: /veterinaria/views/admin/index.php");
                            break;
                        case 'veterinario':
                            header("Location: /veterinaria/views/veterinario/index.php");
                            break;
                        case 'recepcionista':
                            header("Location: /veterinaria/views/recepcionista/index.php");
                            break;
                        default:
                            header("Location: login.php");
                    }
                    exit;
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "Usuario no encontrado.";
            }
        } catch (PDOException $e) {
            $error = "Error de base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2 class="login-title">Iniciar Sesión</h2>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" value="<?= htmlspecialchars($usuario); ?>" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>

            <div class="d-grid">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
        </form>
    </div>

</body>

</html>