<?php 
session_start();
require_once __DIR__ . '/../includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinishLine - Pintura Industrial</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Contacto.css">
</head>

<main class="contact-container">
    <div class="contact-header">
        <h1>Contacta con <span>Nosotros</span></h1>
        <div class="divider"></div>
        <p>¿Tienes un proyecto en mente? Nuestro equipo técnico está listo para asesorarte en acabados de alta resistencia.</p>
    </div>

    <div class="contact-content">
        <div class="contact-info">
            <div class="info-card">
                <h3>Información de Contacto</h3>
                <div class="info-item">
                    <span class="icon">📍</span>
                    <p>Villaverde Bajo, Calle del Diamante, 40, Madrid, España</p>
                </div>
                <div class="info-item">
                    <span class="icon">📞</span>
                    <p>+34 912 345 678</p>
                </div>
                <div class="info-item">
                    <span class="icon">✉️</span>
                    <p>info@finishline.com</p>
                </div>
                <div class="info-item">
                    <span class="icon">🕒</span>
                    <p>Lunes - Viernes: 7:30 - 20:00</p>
                </div>
                <div class="info-item">
                    <span class="icon">🕒</span>
                    <p>Sabado - Domingo: 10:00 - 14:00</p>
                </div>
            </div>
            <!-- ARREGLAR MAPA  -->
            <div class="contact-map">
                <div class="map-placeholder">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d760.1562731160211!2d-3.686907830405229!3d40.350662020266576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4226c1bdcb8183%3A0x8f7d1f36622820e!2sC.%20del%20Diamante%2C%2040%2C%20Villaverde%2C%2028021%20Madrid!5e0!3m2!1ses!2ses!4v1776842693842!5m2!1ses!2ses">
                    </iframe>
                    <span>Ubicación Estratégica</span>
                </div>
            </div>
        </div>

        <div class="contact-form-container">
            <form action="#" method="POST" class="modern-form">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre..." required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="form-group">
                    <label for="asunto">Asunto</label>
                    <select id="asunto" name="asunto">
                        <option value="presupuesto">Solicitar Presupuesto</option>
                        <option value="tecnico">Asesoría Técnica</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" maxlength="400" placeholder="Cuéntanos sobre tu proyecto..." required></textarea>
                    <div id="char-count" class="char-counter">0 / 400 caracteres</div>
                </div>
                
                <script src="/src/scripts/ContadorContacto.js"></script> <!-- Script maximo de caracteres  -->

                <button type="submit" class="btn-submit">Enviar Mensaje</button>
            </form>
        </div>

    </div>
</main>

</body>
</html>