<?php
/**
 * Variables inyectadas desde panel.php
 * @var array $stats
 * @var array $tickets
 * @var array $colores_estado
 */
?>

<section class="tab-content" id="tab-tickets">
    <h1 class="admin-titulo">Gestión de Tickets</h1>
    <input type="text" id="buscadorTickets" placeholder="🔍 Buscar por cliente, matrícula o estado..." class="buscador-input">
    <div class="tabla-wrapper">
        <table class="admin-tabla" id="tablaTickets">
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Servicio</th><th>Matrícula</th>
                    <th>Fecha inicio</th><th>Presupuesto</th><th>Estado</th><th>Cambiar estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $t): ?>
                <tr>
                    <td>#<?= $t['id_ticket'] ?></td>
                    <td>
                        <?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido']) ?>
                        <br><small style="color:#999"><?= htmlspecialchars($t['Correo']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($t['servicio'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($t['matricula'] ?? '—') ?></td>
                    <td><?= $t['fecha_inicio'] ?? '—' ?></td>
                    <td><?= $t['presupuesto'] ? number_format($t['presupuesto'], 2) . ' €' : '—' ?></td>
                    <td>
                        <span class="badge-estado" style="background:<?= $colores_estado[$t['estado']] ?? '#999' ?>">
                            <?= htmlspecialchars($t['estado']) ?>
                        </span>
                    </td>
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