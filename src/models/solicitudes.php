<?php

class SolicitudModel
{
    private $conn;
    private string $table = 'Solicitudes';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function crear(array $data): int
    {
        $sql = "INSERT INTO {$this->table}
                    (id_usuario, nombre, correo, asunto, mensaje, fecha_envio, estado)
                VALUES
                    (:id_usuario, :nombre, :correo, :asunto, :mensaje, NOW(), 'pendiente')";

        $stmt = $this->conn->prepare($sql);

        // ✅ Bindeamos id_usuario explícitamente para forzar NULL correcto
        $stmt->bindValue(':id_usuario', $data['id_usuario'] ?? null,
            $data['id_usuario'] ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(':nombre',  $data['nombre'],  PDO::PARAM_STR);
        $stmt->bindValue(':correo',  $data['correo'],  PDO::PARAM_STR);
        $stmt->bindValue(':asunto',  $data['asunto'],  PDO::PARAM_STR);
        $stmt->bindValue(':mensaje', $data['mensaje'], PDO::PARAM_STR);

        $stmt->execute();

        $id = (int) $this->conn->lastInsertId();

        if ($id === 0) {
            throw new \RuntimeException('No se pudo insertar la solicitud en la BD.');
        }

        return $id;
    }

    public function obtenerTodas(): array
    {
        $sql = "SELECT s.*, u.Nombre AS usuario_nombre, u.Apellido AS usuario_apellido
                FROM {$this->table} s
                LEFT JOIN Usuario u ON s.id_usuario = u.id_usuario
                ORDER BY s.fecha_envio DESC";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT s.*, u.Nombre AS usuario_nombre, u.Apellido AS usuario_apellido
                FROM {$this->table} s
                LEFT JOIN Usuario u ON s.id_usuario = u.id_usuario
                WHERE s.id_solicitud = :id
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado(int $id, string $estado): bool
    {
        $estadosValidos = ['pendiente', 'atendida', 'cancelada'];
        if (!in_array($estado, $estadosValidos, true)) {
            return false;
        }

        $sql  = "UPDATE {$this->table} SET estado = :estado WHERE id_solicitud = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }
}