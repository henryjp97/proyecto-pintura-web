<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinishLine</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        
        /* Barra de Login Superior */
        .header-top {
            background-color: #505255; 
            padding: 8px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-size: 14px;
        }

        .login-form input { 
            padding: 5px; 
            border-radius: 3px; 
            border: none; 
            margin-left: 5px;
        }

        .btn-login { 
            background: #28a745; 
            color: white; 
            border: none; 
            padding: 5px 15px; 
            cursor: pointer; 
            border-radius: 3px;
        }
        .btn-register { 
            background: #6c757d; /* Gris para diferenciarlo del entrar */
            color: white; 
            padding: 5px 15px; 
            border-radius: 3px;
            text-decoration: none;
            font-size: 13.3px; /* Para igualar al tamaño de botón por defecto */
            display: inline-block;
            margin-left: 5px;
        }
        /* Navegación Principal (Según tu imagen) */
        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: white;
        }
        .main-nav img { height: 50px; }
        .menu a { text-decoration: none; color: #333; margin-left: 20px; font-size: 14px; }

        /* Sección de Cuadros de Servicios */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            color: white;
            text-align: center;
        }
        /* Contenedor de la rejilla */
.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columnas iguales */
    width: 100%;
    line-height: 0; /* Quita espacios fantasma entre imágenes */
}

/* Contenedor de la imagen */
.service-image {
    width: 100%;
    aspect-ratio: 1 / 1; /* Fuerza a que sea un cuadrado perfecto */
    overflow: hidden;    /* Corta lo que sobre de la imagen */
}

/* La imagen en sí */
.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;   /* Llena el cuadrado sin deformarse (centra la foto) */
    display: block;
}

/* Ajuste para que los cuadros azules también sean cuadrados y alineen */
.service-box {
    aspect-ratio: 1 / 1; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
    line-height: normal; /* Restablece el texto */
    text-align: center;
}
        .service-box { padding: 40px 20px; min-height: 200px; }
        .bg-blue-dark { background-color: #005682; }
        .bg-blue-light { background-color: #007bb5; }
        .service-box img { width: 100%; height: 200px; object-fit: cover; }

        /* Banner de Bienvenida */
        .welcome-banner {
            background-color: #005682;
            color: white;
            text-align: center;
            padding: 60px 20px;
        }
        .welcome-banner h1 { font-size: 36px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <header class="header-top">
        <div>Servicios Pintura</div>
        <div class="auth-section">
            <?php if (!isset($_SESSION['usuario'])): ?>
                <form action="src/controllers/AuthController.php" method="POST" style="display: inline;">
                    <input type="text" name="user" placeholder="Usuario" required>
                    <input type="password" name="pass" placeholder="Contraseña" required>
                    <button type="submit" class="btn-login">Entrar</button>
                </form>
                
                <a href="src/views/registro.php" class="btn-register">Registrar</a>
                
            <?php else: ?>
                <span>Bienvenido, <strong><?php echo $_SESSION['usuario']['nombre']; ?></strong></span>
                <a href="src/controllers/logout.php" style="color: #ff9999; margin-left: 15px; text-decoration: none;">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <nav class="main-nav">
        <div class="logo"><strong>FINISHLINE</strong></div>
        <div class="menu">
            <a href="#">Inicio</a>
            <a href="#">Quiénes somos</a>
            <a href="#">Servicios</a>
            <a href="#">Galería</a>
            <a href="#">Contacto</a>
        </div>
    </nav>

    <section class="services-grid">
        <div class="service-image"><img src="img/imagen1.jpg" alt="Maquinaria"></div>
        <div class="service-box bg-blue-dark">
            <h3>Somos su empresa de confianza</h3>
            <p>PINTURA INDUSTRIAL</p>
        </div>
        <div class="service-image"><img src="img/imagen2.jpg" alt="Oficina"></div>
        
        <div class="service-box bg-blue-light">
            <h3>Procesos de pintura homologados</h3>
            <p>Confíe en nosotros...</p>
        </div>
        <div class="service-image"><img src="img/imagen3.jpg" alt="Cabina"></div>
        <div class="service-box bg-blue-dark">
            <h3>Asesoría en recubrimientos</h3>
            <p>Nuestro equipo de profesionales...</p>
        </div>
    </section>

    <section class="welcome-banner">
        <h1>Bienvenido FINISHLINE</h1>
        <p>Especialistas en chapa, pintura y acabados profesionales</p>
    </section>

</body>
</html>