<?php
session_start();
require_once 'src/config/conexion.php';

// Si no hay sesión redirige al login
if (!isset($_SESSION['usuario'])) {
    header('Location: /src/views/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FinishLine</title>
</head>
<body>
    <h1>Bienvenido <?= $_SESSION['usuario']['nombre'] ?></h1>
    <a href="/src/controllers/AuthController.php?action=logout">Cerrar sesión</a>
</body>
</html>