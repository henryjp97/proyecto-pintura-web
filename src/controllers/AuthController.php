<?php
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../config/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {
    private $usuarioModel;

    public function __construct($conn) {
        $this->usuarioModel = new Usuario($conn);
    }

    // --- MÉTODO DE REGISTRO (Faltaba este en tu último mensaje) ---
    public function registro($datos) {
        if (empty($datos['nombre']) || empty($datos['apellido']) || 
            empty($datos['correo']) || empty($datos['password'])) {
            return ['error' => 'Todos los campos son obligatorios'];
        }

        if ($this->usuarioModel->existeCorreo($datos['correo'])) {
            return ['error' => 'El correo ya está registrado'];
        }

        $resultado = $this->usuarioModel->registrar(
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'] ?? '', // Evita error si no viene teléfono
            $datos['correo'],
            $datos['password']
        );

        if ($resultado) {
            return ['success' => 'Usuario registrado correctamente'];
        }
        return ['error' => 'Error al registrar el usuario'];
    }

    // --- MÉTODO DE LOGIN ---
    public function login($correo, $password) {
        $usuario = $this->usuarioModel->login($correo, $password);

        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id_usuario'],
                'nombre' => $usuario['Nombre'],
                'correo' => $usuario['Correo'],
                'rol' => $usuario['Rol']
            ];
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        header('Location: /index.php');
        exit();
    }
}

// --- LÓGICA DE PROCESAMIENTO PARA EL LOGIN DEL INDEX ---
// --- LÓGICA DE PROCESAMIENTO PARA EL LOGIN DEL INDEX ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user']) && isset($_POST['pass'])) {
    $controller = new AuthController($conn);
    $exito = $controller->login($_POST['user'], $_POST['pass']);

    if ($exito) {
        header('Location: /index.php');
    } else {
        header('Location: /index.php?error=1');
    }
    exit();
}