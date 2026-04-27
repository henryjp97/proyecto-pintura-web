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
    <title>FinishLine - Quiénes Somos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Header.css">
    <link rel="stylesheet" href="/src/styles/Footer.css">
   <link rel="stylesheet" href="/src/styles/QuienesSomos.css">
</head>
<body>

    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <!-- BANNER -->
    <section class="qs-banner">
        <div class="qs-banner-content">
            <h1>Quiénes Somos</h1>
            <p>Pasión por el detalle, compromiso con la calidad</p>
        </div>
    </section>

    <!-- NUESTRA HISTORIA -->
    <section class="qs-historia">
        <div class="qs-container">
            <div class="qs-texto">
                <h2>Nuestra Historia</h2>
                <div class="divider"></div>
                <p>FinishLine nació con una vocación clara: ofrecer los más altos estándares en chapa, pintura y acabados industriales. Con más de 10 años de experiencia en el sector, hemos trabajado con flotas de vehículos, talleres mecánicos y empresas industriales de toda España.</p>
                <p>Desde nuestras instalaciones en Madrid, combinamos tecnología de vanguardia con el conocimiento técnico de nuestro equipo para garantizar resultados excepcionales en cada proyecto.</p>
            </div>
            <div class="qs-imagen">
                <img src="/img/imagen3.jpg" alt="Taller FinishLine">
            </div>
        </div>
    </section>

    <!-- MISIÓN Y VISIÓN -->
    <section class="qs-mision">
        <div class="qs-container qs-mision-grid">
            <div class="qs-mision-card">
                <span class="qs-icon">🎯</span>
                <h3>Nuestra Misión</h3>
                <p>Devolver cada vehículo o pieza a su estado óptimo, combinando técnica, precisión y los mejores materiales del mercado para superar las expectativas de nuestros clientes.</p>
            </div>
            <div class="qs-mision-card">
                <span class="qs-icon">🔭</span>
                <h3>Nuestra Visión</h3>
                <p>Ser la empresa de referencia en acabados industriales en España, reconocida por su innovación, calidad certificada y compromiso con el cliente.</p>
            </div>
            <div class="qs-mision-card">
                <span class="qs-icon">💎</span>
                <h3>Nuestros Valores</h3>
                <p>Honestidad, precisión técnica y orientación al cliente son los pilares que guían cada trabajo que realizamos, desde el más pequeño retoque hasta proyectos de gran envergadura.</p>
            </div>
        </div>
    </section>

    <!-- POR QUÉ ELEGIRNOS -->
    <section class="qs-elegir">
        <div class="qs-container">
            <h2 class="text-center">¿Por qué elegirnos?</h2>
            <div class="divider mx-auto"></div>
            <div class="qs-elegir-grid">
                <div class="qs-elegir-card">
                    <span class="qs-icon">🔧</span>
                    <h4>Experiencia</h4>
                    <p>Más de 10 años en el sector industrial avalando cada trabajo que realizamos.</p>
                </div>
                <div class="qs-elegir-card">
                    <span class="qs-icon">✅</span>
                    <h4>Calidad Certificada</h4>
                    <p>Procesos homologados y auditados que garantizan resultados de primer nivel.</p>
                </div>
                <div class="qs-elegir-card">
                    <span class="qs-icon">⚡</span>
                    <h4>Rapidez</h4>
                    <p>Cumplimos plazos sin sacrificar calidad gracias a nuestra organización interna.</p>
                </div>
                <div class="qs-elegir-card">
                    <span class="qs-icon">🛡️</span>
                    <h4>Garantía</h4>
                    <p>Todos nuestros trabajos incluyen garantía de acabado y satisfacción del cliente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NUESTRO EQUIPO -->
    <section class="qs-equipo">
        <div class="qs-container">
            <h2 class="text-center">Nuestro Equipo</h2>
            <div class="divider mx-auto"></div>
            <div class="qs-equipo-grid">
                <div class="qs-equipo-card">
                    <div class="qs-avatar">👤</div>
                    <h4>Nicolás Arribas Jiménez</h4>
                    <span>Director Técnico</span>
                    <p>Más de 15 años de experiencia liderando proyectos de pintura industrial.</p>
                </div>
                <div class="qs-equipo-card">
                    <div class="qs-avatar">
                        <img src="/img/Jhorib.png" alt="Jhorib Stephano">
                    </div>
                    <h4>Jhorib Stephano Sequeiros Huillca </h4>
                    <span>Especialista en Chapa</span>
                    <p>Experto en reparación y modelado de carrocerías con técnicas avanzadas.</p>
                </div>
                <div class="qs-equipo-card">
                    <div class="qs-avatar">
                        <img src="/img/HenryCantoral.jpeg" alt="Henry Cantoral">
                    </div>
                    <h4>Henry Cantoral Florian</h4>
                    <span>Técnico de Pintura Industrial</span>
                    <p>Especializado en acabados de alta resistencia y tratamientos superficiales.</p>
                </div>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>