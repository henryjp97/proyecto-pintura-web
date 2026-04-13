<?php
require_once __DIR__ . '/../controllers/AuthController.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController($conn);
    $resultado = $controller->registro($_POST);
    
    if (isset($resultado['success'])) {
        header('Location: /src/views/login.php');
        exit();
    } else {
        $mensaje = $resultado['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FinishLine</title>
</head>
<body>

    <h1>Crear cuenta</h1>

    <?php if ($mensaje): ?>
        <p style="color:red"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="telefono" placeholder="Teléfono">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="/src/views/login.php">Inicia sesión</a></p>

</body>
</html>