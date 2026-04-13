<?php
require_once __DIR__ . '/../../src/controllers/AuthController.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController($conn);
    $resultado = $controller->login($_POST['correo'], $_POST['password']);
    
    if (isset($resultado['success'])) {
        header('Location: /index.php');
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
    <title>Login - FinishLine</title>
</head>
<body>

    <h1>Iniciar sesión</h1>

    <?php if ($mensaje): ?>
        <p style="color:red"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="/views/registro.php">Regístrate</a></p>

</body>
</html>