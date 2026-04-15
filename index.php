<?php 
session_start(); 
require_once 'src/config/conexion.php';

// Variable para verificar el estado de la sesión
$usuarioLogueado = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinishLine - Pintura Industrial</title>
    <link rel="stylesheet" href="/src/styles/Index.css">
</head>
<body>

    <header class="header-top">
        <div>Servicios Pintura Industrial</div>
        <div class="auth-section">
            <?php if ($usuarioLogueado): ?>
                <span>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></strong></span>
                <a href="src/controllers/logout.php" style="border:none; color:#ff9999; margin-left:10px">Salir</a>
            <?php else: ?>
                <a href="/src/views/login.php">SIGN IN</a>
            <?php endif; ?>
        </div>
    </header>

    <nav class="main-nav">
        <div class="logo"><strong>FINISHLINE</strong></div>
        <div class="menu">
            <a href="#">Inicio</a>
            <a href="#">Quiénes somos</a>
            <?php 
            if ($usuarioLogueado){?>
                <a href="#">Servicios</a>
            <?php } ?>
            <a href="#">Galería</a>
            <a href="#">Contacto</a>
        </div>
    </nav>

    <section class="welcome-banner">
        <h1>Bienvenido a FINISHLINE</h1>
        <p>Especialistas en chapa, pintura y acabados profesionales de alta resistencia</p>
    </section>

    <section class="section-info">
        <h2>Líderes en el sector</h2>
        <p>Ofrecemos soluciones integrales para la industria, garantizando durabilidad y estética en cada proyecto.</p>
    </section>

    
        <section class="services-grid">
            <div class="service-image"><img src="img/imagen1.jpg" alt="Coche Gris"></div>
            <div class="service-box bg-blue-dark">
                <h3>Somos su empresa de confianza</h3>
                <p>PINTURA INDUSTRIAL</p>
            </div>
            <div class="service-image"><img src="img/imagen2.jpg" alt="Coche Rojo"></div>
            
            <div class="service-box bg-blue-light">
                <h3>Procesos homologados</h3>
                <p>Calidad certificada en cada acabado.</p>
            </div>
            <div class="service-image"><img src="img/imagen3.jpg" alt="Cabina"></div>
            <div class="service-box bg-blue-dark">
                <h3>Asesoría técnica</h3>
                <p>Expertos a su disposición.</p>
            </div>
        </section>
    
        <section class="premium-notice">
            <h3>Nuestros Servicios Premium</h3>
            <p>El catálogo detallado de procesos y acabados está disponible solo para clientes registrados.</p>
            <p><a href="/src/views/login.php" class="btn-link">Inicia sesión</a> para conocer más de nuestros servicios.</p>
        </section>
    

</body>
</html>