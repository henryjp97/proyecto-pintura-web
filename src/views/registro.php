<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// src/views/registro.php
require_once __DIR__ . '/../config/conexion.php'; 
require_once __DIR__ . '/../controllers/AuthController.php';

// Verifica si $conn existe (la variable que creas en conexion.php)
if (!isset($conn)) {
    die("Error: La conexión a la base de datos no está disponible.");
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciamos el controlador
    $controller = new AuthController($conn); 
    
    // Ejecutamos el método registro pasándole los datos del formulario
    $resultado = $controller->registro($_POST);
    
    if (isset($resultado['success'])) {
        header('Location: /index.php?registrado=1'); 
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
    <title>Registro - FinishLine</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #004a7c; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Crear cuenta</h2>

        <?php if ($mensaje): ?>
            <p style="color:red; font-size: 14px;"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p style="font-size: 12px; margin-top: 15px;">
            ¿Ya tienes cuenta? <a href="/index.php">Volver al inicio</a>
        </p>
    </div>
</body>
</html>