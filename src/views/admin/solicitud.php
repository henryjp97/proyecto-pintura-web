<?php
/**
 * tickets.php
 * Vista de gestión de tickets para el rol "admin".
 * @var array $solicitudes
 * @var array $colores_estado
 */
?>

<section class="tab-content" id="tab-solicitud">
    <h1 class="admin-titulo">Solicitudes de Contacto</h1>

    <div class="tabla-wrapper">
        <table class="admin-tabla">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
                <th>Respuestas</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($solicitudes as $s): ?>
                <tr>
                    <td>#<?= (int)$s['id_solicitud'] ?></td>
                    <td><?= htmlspecialchars($s['nombre']) ?></td>
                    <td><?= htmlspecialchars($s['correo']) ?></td>
                    <td><?= htmlspecialchars($s['asunto']) ?></td>
                    <td><?= htmlspecialchars($s['mensaje']) ?></td>
                    <td><?= htmlspecialchars($s['fecha_envio']) ?></td>
                    <td>
                        <button class="btn-sm btn-verde"
                                onclick="abrirModalResponderSolicitud(
                                <?= (int)$s['id_solicitud'] ?>,
                                        '<?= htmlspecialchars($s['nombre'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($s['correo'], ENT_QUOTES) ?>'
                                        )">
                            ✉️ Responder
                        </button>
                    <td>
                        <button class="btn-sm btn-azul"
                                onclick="abrirModalRespuestasSolicitud(<?= (int)$s['id_solicitud'] ?>)">
                            👁 Ver
                        </button>
                    </td>
                    </td>

                </tr>
            <?php endforeach; ?>
            <?php if (empty($solicitudes)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:#9ca3af;">
                        No hay solicitudes aún.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>