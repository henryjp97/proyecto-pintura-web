<?php
// src/controllers/AdminController.php

class AdminController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Listar todos los usuarios
    public function getUsuarios(): array {
        $stmt = $this->conn->query(
            "SELECT id_usuario, Nombre, Apellido, Correo, Telefono, Rol
             FROM Usuario
             ORDER BY Rol, Nombre"
        );
        return $stmt->fetchAll();
    }

    // Obtener un usuario por ID
    public function getUsuario(int $id): array|false {
        $stmt = $this->conn->prepare(
            "SELECT id_usuario, Nombre, Apellido, Correo, Telefono, Rol
             FROM Usuario WHERE id_usuario = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Cambiar ROL a un usuario
    public function cambiarRol(int $id, string $nuevoRol): bool {
        $rolesPermitidos = ['admin', 'empleado', 'cliente'];
        if (!in_array($nuevoRol, $rolesPermitidos)) return false;

        $stmt = $this->conn->prepare(
            "UPDATE Usuario SET Rol = ? WHERE id_usuario = ?"
        );
        return $stmt->execute([$nuevoRol, $id]);
    }

    // Eliminar un usuario
    public function eliminarUsuario(int $id): bool {

        $stmt = $this->conn->prepare(
            "SELECT id_autenticacion FROM Usuario WHERE id_usuario = ?"
        );
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();
        if (!$usuario) return false;

        // Borrar tickets y password_reset del usuario
        $stmt = $this->conn->prepare("DELETE FROM Usuario WHERE id_usuario = ?");
        $stmt->execute([$id]);

        // Borrar la autenticacion
        $stmt = $this->conn->prepare("DELETE FROM Autenticacion WHERE id_autenticacion = ?");
        $stmt->execute([$usuario['id_autenticacion']]);

        return true;
    }

    // Mostrar tickets por ID
    public function getTicketsUsuario(int $id): array {
        $stmt = $this->conn->prepare(
            "SELECT t.id_ticket, t.descripcion, t.matricula, t.estado,
                    t.fecha_inicio, t.fecha_fin, t.presupuesto, t.fecha_cita,
                    s.Nombre AS servicio
             FROM Ticket t
             LEFT JOIN Servicios s ON t.id_servicio = s.ID_servicio
             WHERE t.id_usuario = ?
             ORDER BY t.id_ticket DESC"
        );
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    // Mostrar todos los tickets guardados
    public function getTodosTickets(): array {
        $stmt = $this->conn->query(
            "SELECT t.id_ticket, t.descripcion, t.matricula, t.estado,
                    t.fecha_inicio, t.presupuesto,
                    u.Nombre, u.Apellido, u.Correo,
                    s.Nombre AS servicio
             FROM Ticket t
             LEFT JOIN Usuario u  ON t.id_usuario  = u.id_usuario
             LEFT JOIN Servicios s ON t.id_servicio = s.ID_servicio
             ORDER BY t.id_ticket DESC"
        );
        return $stmt->fetchAll();
    }

    // Cambiar estado de un ticket
    public function cambiarEstadoTicket(int $id, string $estado): bool {
        $permitidos = ['pendiente', 'en proceso', 'completado', 'cancelado'];
        if (!in_array($estado, $permitidos)) return false;

        $stmt = $this->conn->prepare(
            "UPDATE Ticket SET estado = ? WHERE id_ticket = ?"
        );
        return $stmt->execute([$estado, $id]);
    }

    // Estadisticas visuales del panel de control
    public function getStats(): array {
        $stats = [];

        $stats['total_usuarios'] = $this->conn
            ->query("SELECT COUNT(*) FROM Usuario")->fetchColumn();

        $stats['total_clientes'] = $this->conn
            ->query("SELECT COUNT(*) FROM Usuario WHERE Rol = 'cliente'")->fetchColumn();

        $stats['total_empleados'] = $this->conn
            ->query("SELECT COUNT(*) FROM Usuario WHERE Rol = 'empleado'")->fetchColumn();

        $stats['total_tickets'] = $this->conn
            ->query("SELECT COUNT(*) FROM Ticket")->fetchColumn();

        $stats['tickets_pendientes'] = $this->conn
            ->query("SELECT COUNT(*) FROM Ticket WHERE estado = 'pendiente'")->fetchColumn();

        $stats['tickets_en_proceso'] = $this->conn
            ->query("SELECT COUNT(*) FROM Ticket WHERE estado = 'en proceso'")->fetchColumn();

        return $stats;
    }
}
