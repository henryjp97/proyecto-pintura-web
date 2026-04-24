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
    <title>FinishLine - Galería</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/src/styles/Galeria.css">
</head>

<main class="galeria-main">

    <!-- HERO BANNER -->
    <section class="galeria-hero">
        <div class="galeria-hero-content">
            <span class="galeria-hero-tag">Nuestro trabajo</span>
            <h1>Galería de <span>Proyectos</span></h1>
            <p>Cada vehículo es una historia de transformación. Aquí mostramos los resultados que avalan nuestra experiencia.</p>
        </div>
        <div class="galeria-hero-deco"></div>
    </section>

    <!-- FILTROS -->
    <section class="galeria-filtros-section">
        <div class="galeria-filtros">
            <button class="filtro-btn activo" data-filtro="todos">Todos</button>
            <button class="filtro-btn" data-filtro="lijado">Lijado & Pintura</button>
            <button class="filtro-btn" data-filtro="chapa">Chapa & Pintura</button>
            <button class="filtro-btn" data-filtro="pulido">Pulido</button>
            <button class="filtro-btn" data-filtro="piezas">Por Piezas</button>
        </div>
    </section>

    <!-- GRID DE FOTOS -->
    <section class="galeria-grid-section">
        <div class="galeria-grid" id="galeriaGrid">

            <!-- Ítem 1 — grande -->
            <div class="galeria-item grande" data-categoria="lijado">
                <img src="/img/imagen1.jpg" alt="Pintado completo vehículo">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Lijado & Pintura</span>
                    <h3>Renovación completa</h3>
                    <p>Lijado superficial y pintado total del vehículo en color original.</p>
                </div>
            </div>

            <!-- Ítem 2 -->
            <div class="galeria-item" data-categoria="chapa">
                <img src="/img/imagen2.jpg" alt="Chapa y pintura">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Chapa & Pintura</span>
                    <h3>Reparación de carrocería</h3>
                    <p>Reconstrucción y pintado tras golpe lateral.</p>
                </div>
            </div>

            <!-- Ítem 3 -->
            <div class="galeria-item" data-categoria="pulido">
                <img src="/img/imagen3.jpg" alt="Pulido profesional">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Pulido</span>
                    <h3>Pulido orbital</h3>
                    <p>Eliminación de arañazos y recuperación del brillo.</p>
                </div>
            </div>

            <!-- Ítem 4 — grande -->
            <div class="galeria-item grande" data-categoria="piezas">
                <img src="/img/imagen4.jpg" alt="Pintura por piezas">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Por Piezas</span>
                    <h3>Puerta y parachoques</h3>
                    <p>Igualación exacta de color y acabado por piezas.</p>
                </div>
            </div>

            <!-- Ítem 5 -->
            <div class="galeria-item" data-categoria="chapa">
                <img src="/img/imagen1.jpg" alt="Chapa dañada reparada">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Chapa & Pintura</span>
                    <h3>Capó reparado</h3>
                    <p>Deformación corregida y pintado en cabina.</p>
                </div>
            </div>

            <!-- Ítem 6 -->
            <div class="galeria-item" data-categoria="lijado">
                <img src="/img/imagen2.jpg" alt="Lijado y acabado">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Lijado & Pintura</span>
                    <h3>Acabado brillante</h3>
                    <p>Preparación completa con fondo y laca.</p>
                </div>
            </div>

            <!-- Ítem 7 -->
            <div class="galeria-item" data-categoria="pulido">
                <img src="/img/imagen3.jpg" alt="Pulido y cera">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Pulido</span>
                    <h3>Sellado cerámico</h3>
                    <p>Protección a largo plazo con producto cerámico.</p>
                </div>
            </div>

            <!-- Ítem 8 -->
            <div class="galeria-item" data-categoria="piezas">
                <img src="/img/imagen4.jpg" alt="Aleta pintada">
                <div class="galeria-overlay">
                    <span class="galeria-cat">Por Piezas</span>
                    <h3>Aleta delantera</h3>
                    <p>Reparación y pintura de aleta con igualación perfecta.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- LIGHTBOX -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" id="lightboxClose" aria-label="Cerrar">&times;</button>
        <button class="lightbox-nav prev" id="lightboxPrev" aria-label="Anterior">&#8249;</button>
        <div class="lightbox-img-wrap">
            <img src="" alt="" id="lightboxImg">
            <div class="lightbox-info">
                <span id="lightboxCat"></span>
                <h3 id="lightboxTitle"></h3>
            </div>
        </div>
        <button class="lightbox-nav next" id="lightboxNext" aria-label="Siguiente">&#8250;</button>
    </div>
    <div class="lightbox-backdrop" id="lightboxBackdrop"></div>

    <!-- CTA FINAL -->
    <section class="galeria-cta">
        <div class="galeria-cta-inner">
            <h2>¿Quieres un resultado así para tu vehículo?</h2>
            <p>Solicita tu presupuesto sin compromiso y nuestro equipo te asesorará.</p>
            <a href="/src/views/contacto.php" class="btn-cta-galeria">Pedir presupuesto</a>
        </div>
    </section>

</main>

<script>
// ── Filtros ──
const filtros = document.querySelectorAll('.filtro-btn');
const items   = document.querySelectorAll('.galeria-item');

filtros.forEach(btn => {
    btn.addEventListener('click', () => {
        filtros.forEach(b => b.classList.remove('activo'));
        btn.classList.add('activo');
        const cat = btn.dataset.filtro;
        items.forEach(item => {
            const visible = cat === 'todos' || item.dataset.categoria === cat;
            item.style.opacity    = visible ? '1' : '0';
            item.style.transform  = visible ? 'scale(1)' : 'scale(0.92)';
            item.style.pointerEvents = visible ? 'auto' : 'none';
            // colapsar sin romper el grid
            item.style.display = visible ? '' : 'none';
        });
    });
});

// ── Lightbox ──
const lightbox        = document.getElementById('lightbox');
const lightboxBackdrop = document.getElementById('lightboxBackdrop');
const lightboxImg     = document.getElementById('lightboxImg');
const lightboxCat     = document.getElementById('lightboxCat');
const lightboxTitle   = document.getElementById('lightboxTitle');
const lightboxClose   = document.getElementById('lightboxClose');
const lightboxPrev    = document.getElementById('lightboxPrev');
const lightboxNext    = document.getElementById('lightboxNext');

let visibleItems = [];
let currentIndex = 0;

function openLightbox(index) {
    visibleItems = [...items].filter(i => i.style.display !== 'none');
    currentIndex = index;
    updateLightbox();
    lightbox.classList.add('activo');
    lightboxBackdrop.classList.add('activo');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightbox.classList.remove('activo');
    lightboxBackdrop.classList.remove('activo');
    document.body.style.overflow = '';
}

function updateLightbox() {
    const item  = visibleItems[currentIndex];
    const img   = item.querySelector('img');
    const cat   = item.querySelector('.galeria-cat').textContent;
    const title = item.querySelector('h3').textContent;
    lightboxImg.src   = img.src;
    lightboxImg.alt   = img.alt;
    lightboxCat.textContent   = cat;
    lightboxTitle.textContent = title;
}

items.forEach((item, i) => {
    item.addEventListener('click', () => {
        visibleItems = [...items].filter(it => it.style.display !== 'none');
        const visIdx = visibleItems.indexOf(item);
        openLightbox(visIdx);
    });
});

lightboxClose.addEventListener('click', closeLightbox);
lightboxBackdrop.addEventListener('click', closeLightbox);

lightboxPrev.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
    updateLightbox();
});

lightboxNext.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % visibleItems.length;
    updateLightbox();
});

document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('activo')) return;
    if (e.key === 'Escape')      closeLightbox();
    if (e.key === 'ArrowLeft')  { currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length; updateLightbox(); }
    if (e.key === 'ArrowRight') { currentIndex = (currentIndex + 1) % visibleItems.length; updateLightbox(); }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>