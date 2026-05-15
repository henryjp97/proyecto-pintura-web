<?php
class AdminController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* ─────────────────────────── USUARIOS ─────────────────────────── */

    public function getUsuarios(): array {
        $stmt = $this->conn->query(
            "SELECT id_usuario, Nombre, Apellido, Correo, Telefono, Rol
             FROM Usuario ORDER BY Rol, Nombre"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpleados(): array {
        $stmt = $this->conn->query(
            "SELECT id_usuario, Nombre, Apellido, Correo, Telefono
         FROM Usuario WHERE Rol IN ('empleado','admin')
         ORDER BY Nombre"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSolicitud(): array {
        $stmt = $this->conn->query(
            "SELECT s.id_solicitud, s.nombre, s.correo, s.asunto,
                s.mensaje, s.fecha_envio, s.estado
         FROM Solicitudes s"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarRol(int $id, string $nuevoRol): bool {
        if (!in_array($nuevoRol, ['admin','empleado','cliente'])) return false;
        $stmt = $this->conn->prepare("UPDATE Usuario SET Rol = ? WHERE id_usuario = ?");
        return $stmt->execute([$nuevoRol, $id]);
    }

    public function eliminarUsuario(int $id): bool {
        $stmt = $this->conn->prepare("SELECT id_autenticacion FROM Usuario WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();
        if (!$usuario) return false;
        $this->conn->prepare("DELETE FROM Usuario WHERE id_usuario = ?")->execute([$id]);
        $this->conn->prepare("DELETE FROM Autenticacion WHERE id_autenticacion = ?")->execute([$usuario['id_autenticacion']]);
        return true;
    }

    /* ─────────────────────────── TICKETS ──────────────────────────── */

    public function getTodosTickets(): array {
        $stmt = $this->conn->query(
            "SELECT t.id_ticket, t.descripcion, t.descripcion_trabajo, t.matricula,
                    t.estado, t.modelo_auto, t.fecha_inicio, t.presupuesto,
                    t.id_empleado,
                    u.id_usuario, u.Nombre, u.Apellido, u.Correo,
                    s.Nombre AS servicio,
                    e.Nombre AS empleado_nombre, e.Apellido AS empleado_apellido
             FROM Ticket t
             LEFT JOIN Usuario u   ON t.id_usuario  = u.id_usuario
             LEFT JOIN Servicios s ON t.id_servicio = s.id_servicio
             LEFT JOIN Usuario e   ON t.id_empleado = e.id_usuario
             ORDER BY t.id_ticket DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTicketsEmpleado(int $idEmpleado): array {
        $stmt = $this->conn->prepare(
            "SELECT t.id_ticket, t.descripcion, t.descripcion_trabajo, t.matricula,
                    t.estado, t.modelo_auto, t.fecha_inicio, t.presupuesto,
                    u.id_usuario, u.Nombre, u.Apellido, u.Correo,
                    s.Nombre AS servicio
             FROM Ticket t
             LEFT JOIN Usuario u   ON t.id_usuario  = u.id_usuario
             LEFT JOIN Servicios s ON t.id_servicio = s.id_servicio
             WHERE t.id_empleado = ?
             ORDER BY t.id_ticket DESC"
        );
        $stmt->execute([$idEmpleado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstadoTicket(int $id, string $estado): bool {
        if (!in_array($estado, ['pendiente','en proceso','completado','cancelado'])) return false;
        $stmt = $this->conn->prepare("UPDATE Ticket SET estado = ? WHERE id_ticket = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function responderTicket(int $id_ticket, int $id_empleado, float $presupuesto, string $descripcion_trabajo): bool {
        $stmt = $this->conn->prepare(
            "UPDATE Ticket
             SET id_empleado         = ?,
                 presupuesto         = ?,
                 descripcion_trabajo = ?,
                 estado              = 'en proceso'
             WHERE id_ticket = ?"
        );
        return $stmt->execute([$id_empleado, $presupuesto, $descripcion_trabajo, $id_ticket]);
    }

    /* ───────────────────────── NOTAS TICKET ───────────────────────── */

    public function getNotasTicket(int $id_ticket): array {
        $stmt = $this->conn->prepare(
            "SELECT n.id_nota, n.nota, n.fecha, n.id_usuario, u.Nombre, u.Apellido
         FROM Nota_X_Ticket n
         LEFT JOIN Usuario u ON n.id_usuario = u.id_usuario
         WHERE n.id_ticket = ?
         ORDER BY n.fecha ASC"
        );
        $stmt->execute([$id_ticket]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardarNota(int $id_ticket, int $id_usuario, string $nota): bool {
        // Siempre inserta una nueva nota, nunca sobreescribe
        $stmt = $this->conn->prepare(
            "INSERT INTO Nota_X_Ticket (id_ticket, id_usuario, nota, fecha) 
         VALUES (?, ?, ?, NOW())"
        );
        return $stmt->execute([$id_ticket, $id_usuario, $nota]);
    }


    /* ──────────────────────────── STATS ───────────────────────────── */

    public function getStats(): array {
        return [
            'total_usuarios'     => $this->conn->query("SELECT COUNT(*) FROM Usuario")->fetchColumn(),
            'total_clientes'     => $this->conn->query("SELECT COUNT(*) FROM Usuario WHERE Rol='cliente'")->fetchColumn(),
            'total_empleados'    => $this->conn->query("SELECT COUNT(*) FROM Usuario WHERE Rol='empleado'")->fetchColumn(),
            'total_tickets'      => $this->conn->query("SELECT COUNT(*) FROM Ticket")->fetchColumn(),
            'tickets_pendientes' => $this->conn->query("SELECT COUNT(*) FROM Ticket WHERE estado='pendiente'")->fetchColumn(),
            'tickets_en_proceso' => $this->conn->query("SELECT COUNT(*) FROM Ticket WHERE estado='en proceso'")->fetchColumn(),
        ];
    }

    public function getStatsEmpleado(int $idEmpleado): array {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Ticket WHERE id_empleado = ?");
        $stmt->execute([$idEmpleado]);
        $total = $stmt->fetchColumn();

        $stmt2 = $this->conn->prepare("SELECT COUNT(*) FROM Ticket WHERE id_empleado = ? AND estado = 'en proceso'");
        $stmt2->execute([$idEmpleado]);
        $en_proceso = $stmt2->fetchColumn();

        $stmt3 = $this->conn->prepare("SELECT COUNT(*) FROM Ticket WHERE id_empleado = ? AND estado = 'completado'");
        $stmt3->execute([$idEmpleado]);
        $completados = $stmt3->fetchColumn();

        return [
            'mis_tickets' => $total,
            'en_proceso'  => $en_proceso,
            'completados' => $completados,
        ];
    }
    /* ─────────────────────── CREAR EMPLEADO ───────────────────────── */

    public function crearEmpleado(
        string $nombre,
        string $apellido,
        string $telefono,
        string $correo,
        string $password
    ): array {

        // Comprobar si el correo ya existe
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM Usuario WHERE Correo = ?"
        );
        $stmt->execute([$correo]);
        if ($stmt->fetchColumn() > 0) {
            return ['ok' => false, 'msg' => 'Ya existe un usuario con ese correo.'];
        }

        try {
            // 1. Insertar en Autenticacion
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $s1   = $this->conn->prepare(
                "INSERT INTO Autenticacion (password_hash) VALUES (?)"
            );
            $s1->execute([$hash]);
            $idAuth = $this->conn->lastInsertId();

            // 2. Insertar en Usuario con Rol = 'empleado'
            $s2 = $this->conn->prepare(
                "INSERT INTO Usuario
                 (id_autenticacion, Nombre, Apellido, Telefono, Correo, Rol)
             VALUES (?, ?, ?, ?, ?, 'empleado')"
            );
            $s2->execute([$idAuth, $nombre, $apellido, $telefono, $correo]);

            return ['ok' => true, 'msg' => "Empleado '$nombre $apellido' creado correctamente."];

        } catch (PDOException $e) {
            return ['ok' => false, 'msg' => 'Error al crear el empleado: ' . $e->getMessage()];
        }
    }
    public function guardarRespuestaTicket(int $id_ticket, string $respuesta): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO Respuesta_x_ticket (id_ticket, respuesta) VALUES (:id_ticket, :respuesta)"
        );
        return $stmt->execute([':id_ticket' => $id_ticket, ':respuesta' => $respuesta]);
    }

    public function getRespuestasTicket(int $id_ticket): array {
        $stmt = $this->conn->prepare(
            "SELECT id_respuesta, respuesta, fecha_respuesta
         FROM Respuesta_x_ticket
         WHERE id_ticket = :id_ticket
         ORDER BY fecha_respuesta DESC"
        );
        $stmt->execute([':id_ticket' => $id_ticket]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function guardarRespuestaSolicitud(int $id_solicitud, string $respuesta): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO Respuesta_x_solicitud (id_solicitud, respuesta) VALUES (:id_solicitud, :respuesta)"
        );
        return $stmt->execute([':id_solicitud' => $id_solicitud, ':respuesta' => $respuesta]);
    }

    public function getRespuestasSolicitud(int $id_solicitud): array {
        $stmt = $this->conn->prepare(
            "SELECT id_respuesta, respuesta, fecha_respuesta
         FROM Respuesta_x_solicitud
         WHERE id_solicitud = :id_solicitud
         ORDER BY fecha_respuesta DESC"
        );
        $stmt->execute([':id_solicitud' => $id_solicitud]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}