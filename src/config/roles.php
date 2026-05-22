<?php
// src/config/roles.php
// Helper centralizado para comprobar roles — úsalo en cualquier vista

function requireLogin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: /src/views/login.php');
        exit();
    }
}

function requireAdmin(): void {
    requireLogin();
    if ($_SESSION['usuario']['rol'] !== 'admin') {
        header('Location: /index.php');
        exit();
    }
}

function requireAdminOrEmpleado(): void {
    requireLogin();
    $rol = $_SESSION['usuario']['rol'];
    if ($rol !== 'admin' && $rol !== 'empleado') {
        header('Location: /index.php');
        exit();
    }
}

function esAdmin(): bool {
    return isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'admin';
}

function esEmpleado(): bool {
    return isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'empleado';
}

function rolActual(): string {
    return $_SESSION['usuario']['rol'] ?? 'cliente';
}
