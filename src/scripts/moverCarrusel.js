function moverCarrusel(direccion) {
        const contenedor = document.getElementById('carruselComentarios');
        const slides = contenedor.querySelectorAll('.carousel-item');
        const dots = contenedor.querySelectorAll('.dot');
        
        // Buscamos el índice actual
        let actual = Array.from(slides).findIndex(s => s.classList.contains('active'));

        // Quitamos la clase activo a lo que hay ahora
        slides[actual].classList.remove('active');
        dots[actual].classList.remove('active');

        // Calculamos el siguiente (con vuelta al principio si llega al final)
        actual = (actual + direccion + slides.length) % slides.length;

        // Añadimos la clase activo al nuevo
        slides[actual].classList.add('active');
        dots[actual].classList.add('active');
    }

    function irASlide(indice) {
        const contenedor = document.getElementById('carruselComentarios');
        const slides = contenedor.querySelectorAll('.carousel-item');
        const dots = contenedor.querySelectorAll('.dot');

        // Limpiar todos
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        // Activar el seleccionado
        slides[indice].classList.add('active');
        dots[indice].classList.add('active');
    }

    // Opcional: Auto-play cada 5 segundos
    setInterval(() => moverCarrusel(1), 5000);