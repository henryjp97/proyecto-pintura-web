<?php

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Registrar usuario
    public function registrar($nombre, $apellido, $telefono, $correo, $password) {
        try {
            // Primero insertamos en Autenticacion
            $stmt = $this->conn->prepare(
                "INSERT INTO Autenticacion (password_hash) VALUES (?)"
            );
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt->execute([$password_hash]);
            
            // Obtenemos el id generado
            $id_autenticacion = $this->conn->lastInsertId();

            // Luego insertamos en Usuario
            $stmt = $this->conn->prepare(
                "INSERT INTO Usuario (id_autenticacion, Nombre, Apellido, Telefono, Correo) 
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$id_autenticacion, $nombre, $apellido, $telefono, $correo]);
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Login usuario
    public function login($correo, $password) {
        try {
            $stmt = $this->conn->prepare(
                "SELECT u.*, a.password_hash 
                 FROM Usuario u 
                 JOIN Autenticacion a ON u.id_autenticacion = a.id_autenticacion 
                 WHERE u.Correo = ?"
            );
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                return $usuario;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Verificar si el correo ya existe
    public function existeCorreo($correo) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM Usuario WHERE Correo = ?"
        );
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }
}
?>