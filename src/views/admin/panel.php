<?php
/**
 * panel.php  ─  Punto de entrada del panel de administración/empleado
 *
 * Detecta el rol del usuario en sesión y enruta a la vista correcta.
 * Requiere: AdminController, PHPMailer (solo para el envío de correo del admin).
 */

session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../controllers/AdminController.php';

/* ── 1. Autenticación ───────────────────────────────────────────────── */
if (empty($_SESSION['usuario'])) {
    header('Location: /src/views/auth/login.php');
    exit;
}

$rolActual = $_SESSION['usuario']['rol'] ?? 'cliente';
$idActual  = (int)($_SESSION['usuario']['id'] ?? 0);
$esAdmin    = ($rolActual === 'admin');
$esEmpleado = ($rolActual === 'empleado');

// Solo admin y empleado pueden entrar aquí
if (!$esAdmin && !$esEmpleado) {
    header('Location: /index.php');
    exit;
}
$database = new Database();
$conn     = $database->getConnection();
/* ── 2. Instancia del controlador ──────────────────────────────────── */
$admin = new AdminController($conn);

/* ── 3. Procesar acciones POST ─────────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    /* ── Acciones solo para ADMIN ── */
    if ($esAdmin) {

        if ($accion === 'cambiar_rol') {
            $admin->cambiarRol((int)$_POST['id_usuario'], $_POST['rol']);
        }

        if ($accion === 'eliminar_usuario') {
            $admin->eliminarUsuario((int)$_POST['id_usuario']);
        }

        if ($accion === 'cambiar_estado_ticket') {
            $admin->cambiarEstadoTicket((int)$_POST['id_ticket'], $_POST['estado']);
        }

        if ($accion === 'responder_ticket') {
            $id_ticket           = (int)$_POST['id_ticket'];
            $id_empleado         = (int)$_POST['id_empleado'];
            $presupuesto         = (float)$_POST['presupuesto'];
            $descripcion_trabajo = trim($_POST['descripcion_trabajo']);

            $ok = $admin->responderTicket($id_ticket, $id_empleado, $presupuesto, $descripcion_trabajo);

            if ($ok && !empty($_POST['correo_cliente'])) {
                require_once __DIR__ . '/../../config/mailer.php';
                try {
                    $mail = crearMailer();
                    $mail->addAddress($_POST['correo_cliente']);
                    $mail->isHTML(true);
                    $mail->Subject = "Tu ticket #{$id_ticket} ha sido atendido – FinishLine";
                    $mail->Body    = "
                        <h2>¡Hemos revisado tu solicitud!</h2>
                        <p><strong>Ticket #:</strong> {$id_ticket}</p>
                        <p><strong>Presupuesto:</strong> " . number_format($presupuesto, 2) . " €</p>
                        <p><strong>Descripción:</strong><br>" . nl2br(htmlspecialchars($descripcion_trabajo)) . "</p>
                        <p>Puedes seguir el estado de tu vehículo accediendo a tu área de cliente.</p>
                        <p>— Equipo FinishLine</p>
                    ";
                    $mail->send();
                } catch (Exception $e) {
                    error_log('Mailer Error: ' . $e->getMessage());
                }
            }

        }
        if ($accion === 'responder_ticket') {
            $id_ticket           = (int)$_POST['id_ticket'];
            $id_empleado         = (int)$_POST['id_empleado'];
            $presupuesto         = (float)$_POST['presupuesto'];
            $descripcion_trabajo = trim($_POST['descripcion_trabajo']);

            $ok = $admin->responderTicket($id_ticket, $id_empleado, $presupuesto, $descripcion_trabajo);

            // ← AÑADE ESTO
            if ($ok) {
                $admin->guardarRespuestaTicket($id_ticket, $descripcion_trabajo);
            }

            if ($ok && !empty($_POST['correo_cliente'])) {
                // ... resto del mailer sin cambios ...
            }
        }

        // ── Crear empleado: SOLO ADMIN ──
        if ($accion === 'crear_empleado') {
            $resultado = $admin->crearEmpleado(
                    trim($_POST['nombre']   ?? ''),
                    trim($_POST['apellido'] ?? ''),
                    trim($_POST['telefono'] ?? ''),
                    trim($_POST['correo']   ?? ''),
                    $_POST['password']      ?? ''
            );
            // Guardamos en sesión para sobrevivir el redirect
            $_SESSION['flash_empleado'] = [
                    'msg'  => $resultado['msg'],
                    'tipo' => $resultado['ok'] ? 'ok' : 'error',
            ];
        }
        if ($accion === 'responder_solicitud') {
            $id_solicitud = (int)$_POST['id_solicitud'];
            $respuesta    = trim($_POST['respuesta']);

            $ok = $admin->guardarRespuestaSolicitud($id_solicitud, $respuesta);

            if ($ok && !empty($_POST['correo_cliente'])) {
                require_once __DIR__ . '/../../config/mailer.php';
                try {
                    $mail = crearMailer();
                    $mail->addAddress($_POST['correo_cliente']);
                    $mail->isHTML(true);
                    $mail->Subject = "Respuesta a tu solicitud – FinishLine";
                    $mail->Body    = "
                <h2>Hemos respondido a tu solicitud</h2>
                <p><strong>Respuesta:</strong><br>" . nl2br(htmlspecialchars($respuesta)) . "</p>
                <p>— Equipo FinishLine</p>
            ";
                    $mail->send();
                } catch (Exception $e) {
                    error_log('Mailer Error: ' . $e->getMessage());
                }
            }
        }
    }

    /* ── Acciones para ADMIN y EMPLEADO ── */
    if ($esEmpleado || $esAdmin) {
        if ($accion === 'guardar_nota') {
            $admin->guardarNota((int)$_POST['id_ticket'], $idActual, trim($_POST['nota']));
        }
        if ($accion === 'cambiar_estado_ticket' && $esEmpleado) {
            $admin->cambiarEstadoTicket((int)$_POST['id_ticket'], $_POST['estado']);
        }
    }


    // Redirect siempre al final para evitar reenvío del formulario
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

/* ── Leer flash de sesión (tras redirect) ───────────────────────────── */
$mensajeEmpleado     = $_SESSION['flash_empleado']['msg']  ?? '';
$tipoMensajeEmpleado = $_SESSION['flash_empleado']['tipo'] ?? '';
unset($_SESSION['flash_empleado']); // limpiar tras leer


/* ── 4. Cargar datos según el rol ──────────────────────────────────── */
$colores_estado = [
        'pendiente'  => '#f59e0b',
        'en proceso' => '#3b82f6',
        'completado' => '#10b981',
        'cancelado'  => '#ef4444',
];
$colores_rol = [
        'admin'    => '#7c3aed',
        'empleado' => '#0891b2',
        'cliente'  => '#64748b',
];

if ($esAdmin) {
    $stats     = $admin->getStats();
    $tickets   = $admin->getTodosTickets();
    $usuarios  = $admin->getUsuarios();
    $solicitudes  = $admin->getSolicitud();
    $empleados = $admin->getEmpleados();
} else {
    $stats   = $admin->getStatsEmpleado($idActual);
    $tickets = $admin->getTicketsEmpleado($idActual);
    $notasPorTicket = [];
    foreach ($tickets as $t) {
        $notas  = $admin->getNotasTicket((int)$t['id_ticket']);
        $miNota = '';
        foreach ($notas as $n) {
            if ((int)$n['id_usuario'] === $idActual) { // ← corregido
                $miNota = $n['nota'];
                break;
            }
        }
        $notasPorTicket[$t['id_ticket']] = $miNota;
    }
}

/* ── 5. Renderizar vista ────────────────────────────────────────────── */
$vistaBase = $esAdmin ? 'admin' : 'empleado';

// Helper para las vistas
function esAdmin(): bool {
    return ($_SESSION['usuario']['rol'] ?? '') === 'admin';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel – FinishLine</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/admin.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">FINISH<span>LINE</span></div>
    <div class="sidebar-rol">Panel de <?= $esAdmin ? 'Administración' : 'Empleado' ?></div>
    <nav class="sidebar-nav">
        <?php if ($esAdmin): ?>
            <a href="#" class="sidebar-link activo" onclick="mostrarTab(event,'dashboard')">Dashboard</a>
            <a href="#" class="sidebar-link"        onclick="mostrarTab(event,'usuarios')">Usuarios</a>
            <a href="#" class="sidebar-link"        onclick="mostrarTab(event,'tickets')">Tickets</a>
            <a href="#" class="sidebar-link"        onclick="mostrarTab(event,'solicitud')">Solicitud</a>
            <a href="#" class="sidebar-link"        onclick="mostrarTab(event,'empleados')">Empleados</a>
        <?php else: ?>
            <a href="#" class="sidebar-link activo">Mis Tickets</a>
        <?php endif; ?>
    </nav>
    <div class="sidebar-footer">
        <span>👤 <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?></span>
        <a href="/src/views/logout.php" class="btn-logout-admin">Cerrar sesión</a>
        <a href="/index.php"            class="btn-volver-admin">← Volver al sitio</a>
    </div>
</aside>

<main class="admin-main">

    <?php
    if ($esAdmin) {
        include __DIR__ . "/dashboard.php";
        include __DIR__ . "/tickets.php";
        include __DIR__ . "/usuarios.php";
        include __DIR__ . "/solicitud.php";
        include __DIR__ . "/empleados.php";
        include __DIR__ . "/modals.php";
    } else {
        include __DIR__ . "/empleado.php";
    }
    ?>
</main>
<script>
    function mostrarTab(e, tab) {
        e.preventDefault();
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('activo'));
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('activo'));
        document.getElementById('tab-' + tab)?.classList.add('activo');
        e.target.classList.add('activo');
    }
</script>
</body>
</html>