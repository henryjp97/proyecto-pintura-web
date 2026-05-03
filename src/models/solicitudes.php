<?php

class Solicitud {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function crear(array $datos): bool {
        $sql = "INSERT INTO Solicitudes 
                    (id_usuario, nombre, correo, asunto, mensaje)
                VALUES 
                    (:id_usuario, :nombre, :correo, :asunto, :mensaje)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $datos['id_usuario'] ?? null,
            ':nombre'     => $datos['nombre']     ?? null,
            ':correo'     => $datos['correo']     ?? null,
            ':asunto'     => $datos['asunto'],
            ':mensaje'    => $datos['mensaje'],
        ]);
    }

    public function obtenerTodas(): array {
        $sql = "
            SELECT 
                s.id_solicitud,
                s.asunto,
                s.mensaje,
                s.fecha_envio,
                s.estado,
                COALESCE(s.nombre,  CONCAT(u.Nombre, ' ', u.Apellido)) AS nombre,
                COALESCE(s.correo,  u.Correo)                          AS correo
            FROM Solicitudes s
            LEFT JOIN Usuario u ON s.id_usuario = u.id_usuario
            ORDER BY s.fecha_envio DESC
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}