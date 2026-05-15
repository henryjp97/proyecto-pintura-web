<?php /** @var array $tickets @var array $colores_estado @var object $admin */ ?>

<section class="tab-content" id="tab-tickets">
    <h1 class="admin-titulo">Gestión de Tickets</h1>
    <input type="text"
           id="buscadorTickets"
           placeholder="🔍 Buscar por cliente, matrícula o estado…"
           class="buscador-input"
           oninput="filtrarTablaTickets()">

    <div class="tabla-wrapper">
        <table class="admin-tabla" id="tablaTickets">
            <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Matrícula</th>
                <th>Fecha inicio</th>
                <th>Presupuesto</th>
                <th>Empleado asignado</th>
                <th>Estado</th>
                <th>Cambiar estado</th>
                <th>Notas</th>
                <th>Acciones</th>
                <th>Respuesta</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td>#<?= (int)$t['id_ticket'] ?></td>
                    <td>
                        <?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido']) ?>
                        <br><small style="color:#999"><?= htmlspecialchars($t['Correo']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($t['servicio'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($t['matricula'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($t['fecha_inicio'] ?? '—') ?></td>
                    <td><?= $t['presupuesto'] ? number_format((float)$t['presupuesto'], 2) . ' €' : '—' ?></td>

                    <td>
                        <?php if (!empty($t['empleado_nombre'])): ?>
                            <?= htmlspecialchars($t['empleado_nombre'] . ' ' . $t['empleado_apellido']) ?>
                        <?php else: ?>
                            <span style="color:#9ca3af;font-style:italic;">Sin asignar</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge-estado"
                              style="background:<?= $colores_estado[$t['estado']] ?? '#999' ?>">
                            <?= htmlspecialchars($t['estado']) ?>
                        </span>
                    </td>

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

                    <td>
                        <?php $notas = $admin->getNotasTicket((int)$t['id_ticket']); ?>
                        <?php if (!empty($notas)): ?>
                            <details>
                                <summary class="btn-sm btn-gris"
                                         style="cursor:pointer;display:inline-block;list-style:none;">
                                    📋 Ver notas (<?= count($notas) ?>)
                                </summary>
                                <div class="notas-admin-box">
                                    <?php foreach ($notas as $n): ?>
                                        <div class="nota-admin-item">
                                            <strong><?= htmlspecialchars($n['Nombre'] . ' ' . $n['Apellido']) ?></strong>
                                            <span style="color:#9ca3af;font-size:.75rem;margin-left:.5rem;">
                                            <?= htmlspecialchars($n['fecha']) ?>
                                        </span>
                                            <p><?= nl2br(htmlspecialchars($n['nota'])) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </details>
                        <?php else: ?>
                            <span style="color:#9ca3af;font-size:.8rem;">Sin notas</span>
                        <?php endif; ?>
                    </td>

                    <!-- Botón Responder -->
                    <td>
                        <button class="btn-sm btn-verde"
                                onclick="abrirModalResponder(
                                <?= (int)$t['id_ticket'] ?>,
                                        '<?= htmlspecialchars($t['Nombre'] . ' ' . $t['Apellido'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($t['Correo'], ENT_QUOTES) ?>',
                                <?= (int)($t['id_empleado'] ?? 0) ?>,
                                <?= $t['presupuesto'] ? (float)$t['presupuesto'] : 0 ?>,
                                        '<?= htmlspecialchars($t['descripcion_trabajo'] ?? '', ENT_QUOTES) ?>'
                                        )">
                            ✉️ Responder
                        </button>
                    </td>

                    <!-- 👁 Respuestas — abre modal -->
                    <td>
                        <?php $respuestas = $admin->getRespuestasTicket((int)$t['id_ticket']); ?>
                        <?php if (!empty($respuestas)): ?>
                            <button class="btn-sm btn-gris"
                                    onclick="abrirModalRespuestas(<?= (int)$t['id_ticket'] ?>)">
                                👁 Ver (<?= count($respuestas) ?>)
                            </button>
                        <?php else: ?>
                            <span style="color:#9ca3af;font-size:.8rem;">Sin respuestas</span>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<style>
    .btn-verde { background:#10b981;color:#fff;border:none;cursor:pointer;border-radius:6px;padding:.3rem .75rem;font-size:.8rem;transition:background .2s; }
    .btn-verde:hover { background:#059669; }
    .notas-admin-box { background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:.75rem;margin-top:.5rem;min-width:220px;max-width:320px;position:absolute;z-index:10;box-shadow:0 4px 12px rgba(0,0,0,0.1); }
    .nota-admin-item { border-bottom:1px solid #e2e8f0;padding-bottom:.5rem;margin-bottom:.5rem;font-size:.82rem; }
    .nota-admin-item:last-child { border-bottom:none;margin-bottom:0; }
    .nota-admin-item p { margin:.25rem 0 0;color:#374151; }
    details { position:relative; }
</style>

<script>
    const respuestasPorTicket = <?= json_encode(
            array_column(
                    array_map(fn($t) => [
                            'id'         => $t['id_ticket'],
                            'respuestas' => $admin->getRespuestasTicket((int)$t['id_ticket'])
                    ], $tickets),
                    'respuestas', 'id'
            )
    ) ?>;

    function abrirModalRespuestas(idTicket) {
        const respuestas = respuestasPorTicket[idTicket] || [];
        const contenido  = document.getElementById('modalRespuestasContenido');

        contenido.innerHTML = respuestas.length === 0
            ? '<p style="color:#9ca3af">Sin respuestas aún.</p>'
            : respuestas.map(r => `
            <div class="nota-admin-item">
                <span style="color:#9ca3af;font-size:.75rem;">${r.fecha_respuesta}</span>
                <p style="margin:.25rem 0 0;color:#374151;white-space:pre-wrap">${r.respuesta}</p>
            </div>`).join('');

        document.getElementById('modalRespuestasTitulo').textContent = `Respuestas del Ticket #${idTicket}`;
        document.getElementById('modalRespuestas').classList.add('activo');
        document.getElementById('modalRespuestasBackdrop').classList.add('activo');
    }

    function cerrarModalRespuestas() {
        document.getElementById('modalRespuestas').classList.remove('activo');
        document.getElementById('modalRespuestasBackdrop').classList.remove('activo');
    }

    function filtrarTablaTickets() {
        const q = document.getElementById('buscadorTickets').value.toLowerCase();
        document.querySelectorAll('#tablaTickets tbody tr').forEach(fila => {
            fila.style.display = fila.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    function abrirModalResponder(idTicket, cliente, correo, idEmpleadoActual, presupuesto, descTrabajo) {
        document.getElementById('responder_id_ticket').value           = idTicket;
        document.getElementById('responder_correo_cliente').value      = correo;
        document.getElementById('responder_presupuesto').value         = presupuesto || '';
        document.getElementById('responder_descripcion_trabajo').value = descTrabajo || '';
        document.getElementById('modalResponderTitulo').textContent    = `Responder Ticket #${idTicket} — ${cliente}`;

        const sel = document.getElementById('responder_id_empleado');
        if (sel && idEmpleadoActual) {
            for (let opt of sel.options) opt.selected = (parseInt(opt.value) === idEmpleadoActual);
        }

        document.getElementById('modalResponder').classList.add('activo');
        document.getElementById('modalResponderBackdrop').classList.add('activo');
    }

    function cerrarModalResponder() {
        document.getElementById('modalResponder').classList.remove('activo');
        document.getElementById('modalResponderBackdrop').classList.remove('activo');
    }


    }
</script>