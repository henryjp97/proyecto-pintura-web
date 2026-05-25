<?php
require_once __DIR__ . '/../models/adminmodel.php';

class AdminController
{
    public AdminModel $model;

    public function __construct(PDO $conn)
    {
        $this->model = new AdminModel($conn);
    }

    public function handle(): void
    {
        $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

        match ($accion) {
            'cambiar_rol'           => $this->cambiarRol(),
            'eliminar_usuario'      => $this->eliminarUsuario(),
            'crear_empleado'        => $this->crearEmpleado(),
            'cambiar_estado_ticket' => $this->cambiarEstadoTicket(),
            'responder_ticket'      => $this->responderTicket(),
            'guardar_nota'          => $this->guardarNota(),
            'responder_solicitud'   => $this->responderSolicitud(),
            default                 => null,
        };
    }

    private function cambiarRol(): void
    {
        $this->model->cambiarRol((int)$_POST['id_usuario'], $_POST['rol']);
    }

    private function eliminarUsuario(): void
    {
        $this->model->eliminarUsuario((int)$_POST['id_usuario']);
    }

    private function crearEmpleado(): void
    {
        $resultado = $this->model->crearEmpleado(
            trim($_POST['nombre']   ?? ''),
            trim($_POST['apellido'] ?? ''),
            trim($_POST['telefono'] ?? ''),
            trim($_POST['correo']   ?? ''),
            $_POST['password']      ?? ''
        );
        $_SESSION['flash_empleado'] = [
            'msg'  => $resultado['msg'],
            'tipo' => $resultado['ok'] ? 'ok' : 'error',
        ];
    }

    private function cambiarEstadoTicket(): void
    {
        $this->model->cambiarEstadoTicket((int)$_POST['id_ticket'], $_POST['estado']);
    }

    private function responderTicket(): void
    {
        $id_ticket           = (int)$_POST['id_ticket'];
        $id_empleado         = (int)$_POST['id_empleado'];
        $presupuesto         = (float)$_POST['presupuesto'];
        $descripcion_trabajo = trim($_POST['descripcion_trabajo'] ?? '');
        $respuesta           = trim($_POST['respuesta'] ?? $descripcion_trabajo);

        $ok = $this->model->responderTicket($id_ticket, $id_empleado, $presupuesto, $descripcion_trabajo);

        if ($ok) {
            $this->model->guardarRespuestaTicket($id_ticket, $respuesta);
        }

        if ($ok && !empty($_POST['correo_cliente'])) {
            $this->enviarCorreoTicket($id_ticket, $presupuesto, $descripcion_trabajo, $_POST['correo_cliente']);
        }
    }

    private function guardarNota(): void
    {
        $this->model->guardarNota(
            (int)$_POST['id_ticket'],
            (int)$_SESSION['usuario']['id'],
            trim($_POST['nota'])
        );
    }

    private function responderSolicitud(): void
    {
        $id_solicitud = (int)$_POST['id_solicitud'];
        $respuesta    = trim($_POST['respuesta']);

        $ok = $this->model->guardarRespuestaSolicitud($id_solicitud, $respuesta);

        if (!$ok) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=ya_respondida');
            exit;
        }

        if (!empty($_POST['correo_cliente'])) {
            $this->enviarCorreoSolicitud($respuesta, $_POST['correo_cliente']);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    private function enviarCorreoTicket(int $id, float $presupuesto, string $descripcion, string $correo): void
    {
        require_once __DIR__ . '/../config/mailer.php';

        $cuerpoHtml = "
        <h2>¡Hemos revisado tu solicitud!</h2>
        <p><strong>Ticket #:</strong> {$id}</p>
        <p><strong>Presupuesto:</strong> " . number_format($presupuesto, 2) . " €</p>
        <p><strong>Descripción:</strong><br>" . nl2br(htmlspecialchars($descripcion)) . "</p>
        <p>Puedes seguir el estado de tu vehículo accediendo a tu área de cliente.</p>
        <p>— Equipo FinishLine</p>
    ";

        $enviado = enviarCorreo($correo, "Tu ticket #{$id} ha sido atendido – FinishLine", $cuerpoHtml);

        if (!$enviado) {
            error_log("Error al enviar correo del ticket #{$id} a {$correo}");
        }
    }

    private function enviarCorreoSolicitud(string $respuesta, string $correo): void
    {
        require_once __DIR__ . '/../config/mailer.php';

        $cuerpoHtml = "
        <h2>Hemos respondido a tu solicitud</h2>
        <p><strong>Respuesta:</strong><br>" . nl2br(htmlspecialchars($respuesta)) . "</p>
        <p>— Equipo FinishLine</p>
    ";

        $enviado = enviarCorreo($correo, "Respuesta a tu solicitud – FinishLine", $cuerpoHtml);

        if (!$enviado) {
            error_log("Error al enviar correo de solicitud a {$correo}");
        }
    }
}
