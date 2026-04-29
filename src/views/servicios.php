<?php 
session_start();
require_once __DIR__ . '/../config/conexion.php'; 
require_once __DIR__ . '/../includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinishLine - Servicios</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Servicios.css">
</head>

<main class="servicios-container">

    <!-- ENCABEZADO -->
    <div class="servicios-header">
        <h1>Nuestros <span>Servicios</span></h1>
        <div class="divider"></div>
        <p>Tratamientos profesionales de chapa y pintura con los más altos estándares de calidad industrial.</p>
    </div>

    <!-- SERVICIO 1: LIJADO SUPERFICIAL + PINTADO ENTERO -->
    <div class="servicio-card" id="lijado-completo">
        <div class="servicio-imagen">
            <img src="/img/imagen1.jpg" alt="Lijado superficial y pintado completo del vehículo">
            <div class="servicio-badge">Servicio Completo</div>
        </div>
        <div class="servicio-info">
            <div class="servicio-numero">01</div>
            <h2>Lijado Superficial <span>+</span> Pintado Entero</h2>
            <div class="servicio-divider"></div>
            <p class="servicio-descripcion">
                Proceso integral de preparación y acabado total del vehículo. Realizamos un lijado superficial de toda la carrocería para eliminar imperfecciones, oxidaciones leves y restos de pintura antigua, dejando la superficie perfectamente preparada. A continuación, aplicamos una nueva capa de pintura de alta resistencia en todo el vehículo, logrando un acabado uniforme, brillante y duradero. Ideal para renovar completamente la estética de tu coche.
            </p>
            <ul class="servicio-lista">
                <li>✔ Lijado completo de toda la carrocería</li>
                <li>✔ Aplicación de imprimación y fondo</li>
                <li>✔ Pintura de alta resistencia en todo el vehículo</li>
                <li>✔ Acabado brillante profesional</li>
            </ul>
            <a href="/src/views/contacto.php" class="btn-precio">
                <span>Consultar Precio</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    <!-- SERVICIO 2: LIJADO + PINTADO POR PIEZAS -->
    <div class="servicio-card reverse" id="lijado-piezas">
        <div class="servicio-imagen">
            <img src="/img/imagen2.jpg" alt="Reparación y pintura por piezas">
            <div class="servicio-badge">Por Piezas</div>
        </div>
        <div class="servicio-info">
            <div class="servicio-numero">02</div>
            <h2>Lijado <span>+</span> Pintado por Piezas</h2>
            <div class="servicio-divider"></div>
            <p class="servicio-descripcion">
                Reparación y pintura localizada en piezas concretas del vehículo. Ya sea una puerta con arañazos, un parachoques dañado, el capó o cualquier otro elemento, actuamos únicamente sobre la pieza afectada con el mismo nivel de exigencia que un tratamiento completo. El color se ajusta con precisión al tono original del vehículo para que el resultado sea completamente imperceptible.
            </p>
            <ul class="servicio-lista">
                <li>✔ Puertas, parachoques, aletas y más</li>
                <li>✔ Igualación exacta del color original</li>
                <li>✔ Preparación, imprimación y acabado por pieza</li>
                <li>✔ Reparación económica sin repasar todo el coche</li>
            </ul>
            <a href="/src/views/contacto.php" class="btn-precio">
                <span>Consultar Precio</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    <!-- SERVICIO 3: CHAPA + PINTURA -->
    <div class="servicio-card" id="chapa-pintura">
        <div class="servicio-imagen carrusel-wrapper">
            <!-- SLIDE ANTES -->
            <div class="carrusel-slide activo">
                <img src="/img/imagen8.jpeg" alt="Antes - daños en la carrocería">
                <div class="carrusel-etiqueta">ANTES</div>
            </div>
            <!-- SLIDE DESPUÉS -->
            <div class="carrusel-slide">
                <img src="/img/imagen9.jpeg" alt="Después - chapa y pintura terminada">
                <div class="carrusel-etiqueta despues">DESPUÉS</div>
            </div>
            <!-- CONTROLES -->
            <button class="carrusel-btn prev" onclick="moverCarrusel(this, -1)" aria-label="Anterior">&#8249;</button>
            <button class="carrusel-btn next" onclick="moverCarrusel(this, 1)" aria-label="Siguiente">&#8250;</button>
            <!-- PUNTOS -->
            <div class="carrusel-dots">
                <span class="dot activo"></span>
                <span class="dot"></span>
            </div>
            <div class="servicio-badge">Más Solicitado</div>
        </div>
        <div class="servicio-info">
            <div class="servicio-numero">03</div>
            <h2>Chapa <span>+</span> Pintura</h2>
            <div class="servicio-divider"></div>
            <p class="servicio-descripcion">
                Servicio integral de reparación estructural y estética para vehículos con daños por golpes, accidentes o deformaciones en la carrocería. Nuestros especialistas en chapa reconstruyen y alinean las piezas afectadas con herramientas de precisión antes de proceder al pintado definitivo. Un servicio completo que devuelve al vehículo su forma y aspecto originales, por muy serio que sea el daño.
            </p>
            <ul class="servicio-lista">
                <li>✔ Reparación de abolladuras y deformaciones</li>
                <li>✔ Reconstrucción de zonas con daño estructural</li>
                <li>✔ Masilla, lijado fino y pintura de acabado</li>
                <li>✔ Resultado sin rastro del daño original</li>
            </ul>
            <a href="/src/views/contacto.php" class="btn-precio">
                <span>Consultar Precio</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    <!-- SERVICIO 4: PULIDO DE COCHE -->
    <div class="servicio-card reverse" id="pulido">
        <div class="servicio-imagen">
            <img src="/img/imagen4.jpg" alt="Pulido profesional de coche">
            <div class="servicio-badge">Acabado Premium</div>
        </div>
        <div class="servicio-info">
            <div class="servicio-numero">04</div>
            <h2>Pulido <span>Profesional</span> de Coche</h2>
            <div class="servicio-divider"></div>
            <p class="servicio-descripcion">
                Tratamiento estético de alto nivel para recuperar el brillo y la profundidad de color de la pintura original. Con maquinaria de pulido orbital y productos abrasivos de precisión, eliminamos micro-arañazos, marcas de lavado, oxidación superficial y pérdida de brillo acumulada con los años. El resultado es una pintura rejuvenecida, con aspecto de nueva, que protege la carrocería y aumenta el valor del vehículo.
            </p>
            <ul class="servicio-lista">
                <li>✔ Eliminación de micro-arañazos y marcas</li>
                <li>✔ Recuperación del brillo original de la pintura</li>
                <li>✔ Pulido con maquinaria orbital profesional</li>
                <li>✔ Acabado con cera o sellado cerámico opcional</li>
            </ul>
            <a href="/src/views/contacto.php" class="btn-precio">
                <span>Consultar Precio</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    <script src="/src/scripts/moverCarrusel.js"></script> <!-- Mover foto chapa y pintura  -->

    <div class="servicios-cta">
        <h3>¿No encuentras lo que buscas?</h3>
        <p>Contacta con nuestro equipo y te asesoramos sin compromiso sobre cualquier trabajo de chapa y pintura.</p>
        <a href="/src/views/contacto.php" class="btn-cta-final">Hablar con un especialista</a>
    </div>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>