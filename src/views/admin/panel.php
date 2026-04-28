<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/roles.php';
require_once __DIR__ . '/../../controllers/AdminController.php';

requireAdmin();

$database = new Database();
$conn     = $database->getConnection();
$admin    = new AdminController($conn);

$mensaje = '';
$tipo    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'cambiar_rol') {
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

    if ($accion === 'eliminar_usuario') {
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

    <!-- DASHBOARD -->
    <section class="tab-content activo" id="tab-dashboard">
        <h1 class="admin-titulo">Dashboard</h1>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-numero"><?= $stats['total_usuarios'] ?></div><div class="stat-label">Usuarios totales</div></div>
            <div class="stat-card"><div class="stat-numero"><?= $stats['total_clientes'] ?></div><div class="stat-label">Clientes</div></div>
            <div class="stat-card"><div class="stat-numero"><?= $stats['total_empleados'] ?></div><div class="stat-label">Empleados</div></div>
            <div class="stat-card destacada"><div class="stat-numero"><?= $stats['total_tickets'] ?></div><div class="stat-label">Tickets totales</div></div>
            <div class="stat-card amarilla"><div class="stat-numero"><?= $stats['tickets_pendientes'] ?></div><div class="stat-label">Pendientes</div></div>
            <div class="stat-card azul"><div class="stat-numero"><?= $stats['tickets_en_proceso'] ?></div><div class="stat-label">En proceso</div></div>
        </div>

        <h2 class="admin-subtitulo">Últimos 5 tickets</h2>
        <div class="tabla-wrapper">
            <table class="admin-tabla">
                <thead><tr><th>#</th><th>Cliente</th><th>Servicio</th><th>Matrícula</th><th>Estado</th><th>Presupuesto</th></tr></thead>
                <tbody>
                    <?php foreach (array_slice($tickets, 0, 5) as $t): ?>
                    <tr>
                        <td>#<?= $t['id_ticket'] ?></td>
                        <td><?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido']) ?></td>
                        <td><?= htmlspecialchars($t['servicio'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($t['matricula'] ?? '—') ?></td>
                        <td><span class="badge-estado" style="background:<?= $colores_estado[$t['estado']] ?? '#999' ?>"><?= htmlspecialchars($t['estado']) ?></span></td>
                        <td><?= $t['presupuesto'] ? number_format($t['presupuesto'], 2) . ' €' : '—' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- USUARIOS -->
    <section class="tab-content" id="tab-usuarios">
        <h1 class="admin-titulo">Gestión de Usuarios</h1>
        <input type="text" id="buscadorUsuarios" placeholder="🔍 Buscar por nombre, correo o rol..." class="buscador-input">
        <div class="tabla-wrapper">
            <table class="admin-tabla" id="tablaUsuarios">
                <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Rol</th><th>Acciones</th></tr></thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id_usuario'] ?></td>
                        <td><?= htmlspecialchars($u['Nombre'] . ' ' . $u['Apellido']) ?></td>
                        <td><?= htmlspecialchars($u['Correo']) ?></td>
                        <td><?= htmlspecialchars($u['Telefono'] ?? '—') ?></td>
                        <td><span class="badge-rol" style="background:<?= $colores_rol[$u['Rol']] ?? '#999' ?>"><?= htmlspecialchars($u['Rol']) ?></span></td>
                        <td class="acciones-celda">
                            <form method="POST" class="form-inline">
                                <input type="hidden" name="accion"     value="cambiar_rol">
                                <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                                <select name="rol" class="select-rol">
                                    <option value="cliente"  <?= $u['Rol']==='cliente'  ? 'selected':'' ?>>cliente</option>
                                    <option value="empleado" <?= $u['Rol']==='empleado' ? 'selected':'' ?>>empleado</option>
                                    <option value="admin"    <?= $u['Rol']==='admin'    ? 'selected':'' ?>>admin</option>
                                </select>
                                <button type="submit" class="btn-sm btn-azul">Guardar</button>
                            </form>
                            <button class="btn-sm btn-gris" onclick="verTicketsUsuario(<?= $u['id_usuario'] ?>, '<?= htmlspecialchars($u['Nombre']) ?>')">Ver tickets</button>
                            <?php if ($u['id_usuario'] !== (int)$_SESSION['usuario']['id']): ?>
                            <form method="POST" class="form-inline" onsubmit="return confirm('¿Eliminar a <?= htmlspecialchars($u['Nombre']) ?>? Esta acción no se puede deshacer.')">
                                <input type="hidden" name="accion"     value="eliminar_usuario">
                                <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                                <button type="submit" class="btn-sm btn-rojo">Eliminar</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- TICKETS -->
    <section class="tab-content" id="tab-tickets">
        <h1 class="admin-titulo">Gestión de Tickets</h1>
        <input type="text" id="buscadorTickets" placeholder="🔍 Buscar por cliente, matrícula o estado..." class="buscador-input">
        <div class="tabla-wrapper">
            <table class="admin-tabla" id="tablaTickets">
                <thead><tr><th>#</th><th>Cliente</th><th>Servicio</th><th>Matrícula</th><th>Fecha inicio</th><th>Presupuesto</th><th>Estado</th><th>Cambiar estado</th></tr></thead>
                <tbody>
                    <?php foreach ($tickets as $t): ?>
                    <tr>
                        <td>#<?= $t['id_ticket'] ?></td>
                        <td><?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido']) ?><br><small style="color:#999"><?= htmlspecialchars($t['Correo']) ?></small></td>
                        <td><?= htmlspecialchars($t['servicio'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($t['matricula'] ?? '—') ?></td>
                        <td><?= $t['fecha_inicio'] ?? '—' ?></td>
                        <td><?= $t['presupuesto'] ? number_format($t['presupuesto'], 2) . ' €' : '—' ?></td>
                        <td><span class="badge-estado" style="background:<?= $colores_estado[$t['estado']] ?? '#999' ?>"><?= htmlspecialchars($t['estado']) ?></span></td>
                        <td>
                            <form method="POST" class="form-inline">
                                <input type="hidden" name="accion"    value="cambiar_estado_ticket">
                                <input type="hidden" name="id_ticket" value="<?= $t['id_ticket'] ?>">
                                <select name="estado" class="select-rol">
                                    <option value="pendiente"  <?= $t['estado']==='pendiente'  ? 'selected':'' ?>>pendiente</option>
                                    <option value="en proceso" <?= $t['estado']==='en proceso' ? 'selected':'' ?>>en proceso</option>
                                    <option value="completado" <?= $t['estado']==='completado' ? 'selected':'' ?>>completado</option>
                                    <option value="cancelado"  <?= $t['estado']==='cancelado'  ? 'selected':'' ?>>cancelado</option>
                                </select>
                                <button type="submit" class="btn-sm btn-azul">Guardar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<!-- MODAL -->
<div class="modal-backdrop" id="modalBackdrop"></div>
<div class="modal" id="modalTickets">
    <div class="modal-header">
        <h3 id="modalTitulo">Tickets del usuario</h3>
        <button onclick="cerrarModal()" class="modal-close">&times;</button>
    </div>
    <div class="modal-body" id="modalBody"></div>
</div>

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

// Buscadores
document.getElementById('buscadorUsuarios').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaUsuarios tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

document.getElementById('buscadorTickets').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tablaTickets tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Modal tickets por usuario
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
