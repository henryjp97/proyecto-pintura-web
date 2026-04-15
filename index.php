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
    <style>
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #333; }
        
        /* 1. BARRA SUPERIOR (Gris oscuro) */
        .header-top {
            background-color: #505255; 
            padding: 8px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-size: 13px;
        }

        .auth-section a {
            color: white;
            text-decoration: none;
            border: 1px solid #fff;
            padding: 4px 12px;
            border-radius: 3px;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.3s;
        }

        .auth-section a:hover {
            background: white;
            color: #505255;
        }

        /* 2. NAVEGACIÓN (Blanca) */
        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: white;
        }
        .logo { font-size: 26px; letter-spacing: 2px; color: #005682; }
        .menu a { text-decoration: none; color: #333; margin-left: 20px; font-size: 14px; }
        .menu a:hover { color: #007bb5; }

        /* 3. BANNER PRINCIPAL (Azul) */
        .welcome-banner {
            background-color: #005682;
            color: white;
            text-align: center;
            padding: 80px 20px;
        }
        .welcome-banner h1 { font-size: 42px; margin-bottom: 10px; }
        .welcome-banner p { font-size: 18px; opacity: 0.9; }

        /* 4. SECCIÓN LÍDERES (Visible para todos) */
        .section-info {
            text-align: center;
            padding: 60px 20px;
            background: white;
        }
        .section-info h2 { font-size: 28px; margin-bottom: 15px; }
        .section-info p { max-width: 800px; margin: 0 auto; color: #666; }

        /* 5. CUADRÍCULA DE SERVICIOS (Exclusiva) */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            width: 100%;
        }
        .service-image { width: 100%; aspect-ratio: 16 / 9; overflow: hidden; }
        .service-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
        
        .service-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            aspect-ratio: 16 / 9;
        }
        .bg-blue-dark { background-color: #004a70; }
        .bg-blue-light { background-color: #007bb5; }

        /* 6. AVISO PARA NO REGISTRADOS */
        .premium-notice {
            background-color: #fcfcfc;
            padding: 50px 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .btn-link { color: #005682; font-weight: bold; text-decoration: underline; }
    </style>
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