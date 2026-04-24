<?php 
session_start(); 
require_once __DIR__ . '/src/config/conexion.php'; //usar la conexion a la bbdd
require_once __DIR__ . '/src/includes/header.php'; //usar el header
$usuarioLogueado = isset($_SESSION['usuario']); // Variable para verificar el estado de la sesion
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinishLine - Pintura Industrial</title>
<<<<<<< Updated upstream
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
=======
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Index.css">
>>>>>>> Stashed changes
</head>
<body>

    <section class="welcome-banner">
        <div class="banner-content">
            <h1>Bienvenido a FINISHLINE</h1>
            <p>Especialistas en chapa, pintura y acabados profesionales de alta resistencia para el sector industrial.</p>
            <a href="#servicios" class="btn-primary">Descubrir más</a>
        </div>
    </section>

    <section class="section-info">
        <h2>Líderes en el sector</h2>
        <div class="divider"></div>
        <p>Ofrecemos soluciones integrales para la industria, garantizando durabilidad y estética en cada proyecto.</p>
    </section>

    <section id="servicios" class="services-wrapper">
        <div class="services-grid">
            <div class="service-card">
                <div class="service-image"><img src="img/imagen1.jpg" alt="Coche Gris"></div>
                <div class="service-content">
                    <h3>Su empresa de confianza</h3>
                    <p>Pintura industrial de la más alta calidad.</p>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image"><img src="img/imagen2.jpg" alt="Coche Rojo"></div>
                <div class="service-content">
                    <h3>Procesos homologados</h3>
                    <p>Calidad certificada y garantizada en cada acabado.</p>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image"><img src="img/imagen3.jpg" alt="Cabina"></div>
                <div class="service-content">
                    <h3>Asesoría técnica</h3>
                    <p>Expertos a su entera disposición en todo momento.</p>
                </div>
            </div>
<<<<<<< Updated upstream
        </section>
                <?php if(!$usuarioLogueado):
                 ?>
        <section class="premium-notice">
            <h3>Nuestros Servicios Premium</h3>
            <p>El catálogo detallado de procesos y acabados está disponible solo para clientes registrados.</p>
            <p><a href="/src/views/login.php" class="btn-link">Inicia sesión</a> para conocer más de nuestros servicios.</p>
        </section>
        <?php endif; ?>
=======
        </div>
    </section>

    <section id="servicios" class="services-wrapper">
        <div class="services-grid">
            <div class="service-card">
                <div class="service-image"><img src="img/imagen1.jpg" alt="Coche Gris"></div>
                <div class="service-content">
                    <h3>RELLENAR</h3>
                    <p>Pintura industrial de la más alta calidad.</p>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image"><img src="img/imagen2.jpg" alt="Coche Rojo"></div>
                <div class="service-content">
                    <h3>RELLENAR</h3>
                    <p>Calidad certificada y garantizada en cada acabado.</p>
                </div>
            </div>
            
           
        </div>
    </section>
    <?php if (!isset($_SESSION['usuario'])): ?>
    <section class="premium-notice">
        <div class="premium-card">
            <h3>Nuestros Servicios Premium</h3>
            <p>El catálogo detallado de procesos y acabados está disponible exclusivamente para clientes registrados.</p>
            <a href="/src/views/login.php" class="btn-link">Inicia sesión</a>
        </div>
    </section>
<?php endif; ?>
    <?php require_once __DIR__ . '/src/includes/footer.php'; ?>

>>>>>>> Stashed changes
</body>
</html>