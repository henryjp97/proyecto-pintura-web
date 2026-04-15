<?php
require_once __DIR__ . '/../controllers/AuthController.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController($conn);
    $resultado = $controller->login($_POST['correo'], $_POST['password']);
    
    if ($resultado === true) {
        header('Location: /index.php');
        exit();
    } else {
        $mensaje = 'Correo o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FinishLine</title>
    <link rel="stylesheet" href="/src/styles/Login.css">
</head>
<body>

    <div class="login-container">
        <h1>FinishLine</h1>
        <p class="welcome-text">
            Bienvenido a FinishLine, para conocer más de nosotros y nuestro servicio por favor regístrate e inicia sesión.
        </p>

        <?php if ($mensaje): ?>
            <div class="error-mensaje"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <p class="footer-link">
            ¿No tienes cuenta? <a href="/src/views/registro.php">Regístrate aquí</a>
        </p>
    </div>

</body>
</html>