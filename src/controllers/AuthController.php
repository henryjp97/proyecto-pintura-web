<?php
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../config/conexion.php';

session_start();

class AuthController {
    private $usuarioModel;

    public function __construct($conn) {
        $this->usuarioModel = new Usuario($conn);
    }

    // Manejar registro
    public function registro($datos) {
        // Verificar que no falten campos
        if (empty($datos['nombre']) || empty($datos['apellido']) || 
            empty($datos['correo']) || empty($datos['password'])) {
            return ['error' => 'Todos los campos son obligatorios'];
        }

        // Verificar si el correo ya existe
        if ($this->usuarioModel->existeCorreo($datos['correo'])) {
            return ['error' => 'El correo ya está registrado'];
        }

        // Registrar usuario
        $resultado = $this->usuarioModel->registrar(
            $datos['nombre'],
            $datos['apellido'],
            $datos['telefono'],
            $datos['correo'],
            $datos['password']
        );

        if ($resultado) {
            return ['success' => 'Usuario registrado correctamente'];
        }
        return ['error' => 'Error al registrar el usuario'];
    }

    // Manejar login
    public function login($correo, $password) {
        $usuario = $this->usuarioModel->login($correo, $password);

        if ($usuario) {
            // Guardar en sesión
            $_SESSION['usuario'] = [
                'id' => $usuario['id_usuario'],
                'nombre' => $usuario['Nombre'],
                'correo' => $usuario['Correo'],
                'rol' => $usuario['Rol']
            ];
            return ['success' => 'Login correcto'];
        }
        return ['error' => 'Correo o contraseña incorrectos'];
    }

    // Cerrar sesión
    public function logout() {
        session_destroy();
        header('Location: /views/login.php');
        exit();
    }

    // Verificar si hay sesión activa
    public static function verificarSesion() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /views/login.php');
            exit();
        }
    }
}
?>