<?php
/**
 * tab_empleado.php
 *
 * Vista exclusiva para el rol "empleado".
 * Muestra sus tickets asignados con campo de notas inline.
 *
 * Variables esperadas desde panel.php:
 * @var array  $stats              ['mis_tickets', 'en_proceso', 'completados']
 * @var array  $tickets            Tickets asignados al empleado
 * @var array  $notasPorTicket     [id_ticket => texto_nota]
 * @var array  $colores_estado
 */
?>
<section class="tab-content activo" id="tab-empleado">
    <h1 class="admin-titulo">Mis tickets asignados</h1>

    <!-- ── Stats del empleado ─────────────────────────────────────── -->
    <div class="stats-grid">
        <div class="stat-card destacada">
            <div class="stat-numero"><?= (int)$stats['mis_tickets'] ?></div>
            <div class="stat-label">Mis tickets</div>
        </div>
        <div class="stat-card azul">
            <div class="stat-numero"><?= (int)$stats['en_proceso'] ?></div>
            <div class="stat-label">En proceso</div>
        </div>
        <div class="stat-card verde">
            <div class="stat-numero"><?= (int)$stats['completados'] ?></div>
            <div class="stat-label">Completados</div>
        </div>
    </div>

    <!-- ── Buscador ──────────────────────────────────────────────── -->
    <input type="text"
           id="buscadorEmpleado"
           placeholder="🔍 Buscar por cliente, matrícula o estado…"
           class="buscador-input"
           oninput="filtrarTablaEmpleado()">

    <!-- ── Tabla de tickets ──────────────────────────────────────── -->
    <div class="tabla-wrapper">
        <table class="admin-tabla" id="tablaEmpleado">
            <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Matrícula</th>
                <th>Modelo</th>
                <th>Fecha inicio</th>
                <th>Presupuesto</th>
                <th>Estado</th>
                <th>Cambiar estado</th>
                <th>Mis notas</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($tickets)): ?>
                <tr>
                    <td colspan="10" style="text-align:center;padding:2rem;color:#6b7280;">
                        No tienes tickets asignados aún.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($tickets as $t): ?>
                    <?php $miNota = ''; ?>
                    <tr>
                        <td>#<?= (int)$t['id_ticket'] ?></td>
                        <td>
                            <?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido']) ?>
                            <br><small style="color:#999"><?= htmlspecialchars($t['Correo']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($t['servicio'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($t['matricula'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($t['modelo_auto'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($t['fecha_inicio'] ?? '—') ?></td>
                        <td><?= $t['presupuesto'] ? number_format((float)$t['presupuesto'], 2) . ' €' : '—' ?></td>
                        <td>
                        <span class="badge-estado"
                              style="background:<?= $colores_estado[$t['estado']] ?? '#999' ?>">
                            <?= htmlspecialchars($t['estado']) ?>
                        </span>
                        </td>

                        <!-- Cambiar estado -->
                        <td>
                            <form method="POST" class="form-inline">
                                <input type="hidden" name="accion"    value="cambiar_estado_ticket">
                                <input type="hidden" name="id_ticket" value="<?= (int)$t['id_ticket'] ?>">
                                <select name="estado" class="select-rol">
                                    <option value="pendiente"  <?= $t['estado']==='pendiente'  ? 'selected':'' ?>>pendiente</option>
                                    <option value="en proceso" <?= $t['estado']==='en proceso' ? 'selected':'' ?>>en proceso</option>
                                    <option value="completado" <?= $t['estado']==='completado' ? 'selected':'' ?>>completado</option>
                                    <option value="cancelado"  <?= $t['estado']==='cancelado'  ? 'selected':'' ?>>cancelado</option>
                                </select>
                                <button type="submit" class="btn-sm btn-azul">Guardar</button>
                            </form>
                        </td>

                        <!-- Notas inline del empleado -->
                        <td class="celda-notas">
                            <form method="POST" class="form-notas">
                                <input type="hidden" name="accion"    value="guardar_nota">
                                <input type="hidden" name="id_ticket" value="<?= (int)$t['id_ticket'] ?>">
                                <textarea
                                        name="nota"
                                        class="textarea-nota"
                                        rows="3"
                                        placeholder="Escribe el estado del trabajo…"></textarea>
                                <button type="submit" class="btn-sm btn-verde">
                                    💾 Guardar nota
                                </button>
                            </form>

                            <!-- Historial de notas -->
                            <?php $notas = $notasPorTicket[$t['id_ticket']] ?? []; ?>
                            <?php if (!empty($notas)): ?>
                                <div class="historial-notas">
                                    <?php foreach (array_reverse($notas) as $n): ?>
                                        <div class="nota-item">
                                            <span class="nota-fecha"><?= htmlspecialchars($n['fecha']) ?></span>
                                            <p><?= nl2br(htmlspecialchars($n['nota'])) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- ── Estilos extra para esta vista ──────────────────────────────── -->
<style>
    .stat-card.verde { border-top: 3px solid #10b981; }
    .stat-card.verde .stat-numero { color: #10b981; }

    .celda-notas { min-width: 220px; }

    .textarea-nota {
        width: 100%;
        padding: .5rem .65rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: .82rem;
        font-family: inherit;
        resize: vertical;
        background: #f9fafb;
        color: #111827;
        transition: border-color .2s;
        box-sizing: border-box;
        display: block;
        margin-bottom: .4rem;
    }
    .textarea-nota:focus {
        outline: none;
        border-color: #3b82f6;
        background: #fff;
    }

    .btn-verde {
        background: #10b981;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        padding: .3rem .75rem;
        font-size: .8rem;
        transition: background .2s;
    }
    .btn-verde:hover { background: #059669; }
</style>

<!-- ── JS del buscador ────────────────────────────────────────────── -->
<script>
    function filtrarTablaEmpleado() {
        const q     = document.getElementById('buscadorEmpleado').value.toLowerCase();
        const filas = document.querySelectorAll('#tablaEmpleado tbody tr');
        filas.forEach(fila => {
            fila.style.display = fila.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }
</script>