<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/roles.php';
require_once __DIR__ . '/../../controllers/AdminController.php';

requireAdminOrEmpleado();

$database = new Database();
$conn     = $database->getConnection();
$admin    = new AdminController($conn);

$mensaje = '';
$tipo    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'cambiar_rol') {
        if (!esAdmin()) {
            $mensaje = 'No tienes permiso para cambiar roles.';
            $tipo = 'error';
        } else {
            $id  = (int)($_POST['id_usuario'] ?? 0);
            $rol = $_POST['rol'] ?? '';
            if ($id === (int)$_SESSION['usuario']['id']) {
                $mensaje = 'No puedes cambiar tu propio rol.';
                $tipo    = 'error';
            } elseif ($admin->cambiarRol($id, $rol)) {
                $mensaje = 'Rol actualizado correctamente.';
                $tipo    = 'ok';
            } else {
                $mensaje = 'Error al cambiar el rol.';
                $tipo    = 'error';
            }
        }
    }

    if ($accion === 'eliminar_usuario') {
        if (!esAdmin()) {
            $mensaje = 'No tienes permiso para eliminar usuarios.';
            $tipo = 'error';
        } else {
            $id = (int)($_POST['id_usuario'] ?? 0);
            if ($id === (int)$_SESSION['usuario']['id']) {
                $mensaje = 'No puedes eliminar tu propia cuenta.';
                $tipo    = 'error';
            } elseif ($admin->eliminarUsuario($id)) {
                $mensaje = 'Usuario eliminado correctamente.';
                $tipo    = 'ok';
            } else {
                $mensaje = 'Error al eliminar el usuario.';
                $tipo    = 'error';
            }
        }
    }

    if ($accion === 'cambiar_estado_ticket') {
        $id     = (int)($_POST['id_ticket'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        if ($admin->cambiarEstadoTicket($id, $estado)) {
            $mensaje = 'Estado del ticket actualizado.';
            $tipo    = 'ok';
        } else {
            $mensaje = 'Error al actualizar el ticket.';
            $tipo    = 'error';
        }
    }
}

// Datos compartidos entre todas las sub-vistas
$stats    = $admin->getStats();
$usuarios = $admin->getUsuarios();
$tickets  = $admin->getTodosTickets();

$colores_estado = [
    'pendiente'  => '#f59e0b',
    'en proceso' => '#3b82f6',
    'completado' => '#10b981',
    'cancelado'  => '#ef4444',
];
$colores_rol = [
    'admin'    => '#7c3aed',
    'empleado' => '#0ea5e9',
    'cliente'  => '#64748b',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin — FinishLine</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Admin.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">FINISH<span>LINE</span></div>
    <p class="sidebar-rol">Panel de Administración</p>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link activo" data-tab="dashboard">📊 Panel de Control</a>
        <a href="#" class="sidebar-link"        data-tab="usuarios">👥 Usuarios</a>
        <a href="#" class="sidebar-link"        data-tab="tickets">🎫 Tickets</a>
    </nav>
    <div class="sidebar-footer">
        <span>👤 <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
        <a href="/src/views/logout.php" class="btn-logout-admin">Cerrar sesión</a>
        <a href="/index.php"            class="btn-volver-admin">← Volver al sitio</a>
    </div>
</aside>

<main class="admin-main">

    <?php if ($mensaje): ?>
        <div class="alerta <?= $tipo === 'ok' ? 'alerta-ok' : 'alerta-error' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <?php include __DIR__ . '/dashboard.php'; ?>
    <?php include __DIR__ . '/usuarios.php';  ?>
    <?php include __DIR__ . '/tickets.php';   ?>
    <?php include __DIR__ . '/modals.php';    ?>

</main>

<script>
// Tabs
document.querySelectorAll('.sidebar-link[data-tab]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const tab = link.dataset.tab;
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('activo'));
        document.querySelectorAll('.tab-content').forEach(s => s.classList.remove('activo'));
        link.classList.add('activo');
        document.getElementById('tab-' + tab).classList.add('activo');
    });
});

// Buscador usuarios
document.getElementById('buscadorUsuarios').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaUsuarios tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Buscador tickets
document.getElementById('buscadorTickets').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaTickets tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Modal
const todosTickets  = <?= json_encode($tickets) ?>;
const coloresEstado = <?= json_encode($colores_estado) ?>;

function verTicketsUsuario(idUsuario, nombre) {
    const tickets = todosTickets.filter(t => t.id_usuario == idUsuario);
    document.getElementById('modalTitulo').textContent = 'Tickets de ' + nombre;
    let html = '';
    if (!tickets.length) {
        html = '<p style="color:#999;text-align:center;padding:20px">Este usuario no tiene tickets.</p>';
    } else {
        html = '<table class="admin-tabla"><thead><tr><th>#</th><th>Servicio</th><th>Matrícula</th><th>Estado</th><th>Presupuesto</th></tr></thead><tbody>';
        tickets.forEach(t => {
            const color = coloresEstado[t.estado] || '#999';
            html += `<tr><td>#${t.id_ticket}</td><td>${t.servicio||'—'}</td><td>${t.matricula||'—'}</td><td><span class="badge-estado" style="background:${color}">${t.estado}</span></td><td>${t.presupuesto ? parseFloat(t.presupuesto).toFixed(2)+' €' : '—'}</td></tr>`;
        });
        html += '</tbody></table>';
    }
    document.getElementById('modalBody').innerHTML = html;
    document.getElementById('modalTickets').classList.add('activo');
    document.getElementById('modalBackdrop').classList.add('activo');
}

function cerrarModal() {
    document.getElementById('modalTickets').classList.remove('activo');
    document.getElementById('modalBackdrop').classList.remove('activo');
}
document.getElementById('modalBackdrop').addEventListener('click', cerrarModal);
</script>
</body>
</html>