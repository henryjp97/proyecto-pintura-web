    function moverCarrusel(btn, direccion) {
        const wrapper = btn.closest('.carrusel-wrapper');
        const slides  = wrapper.querySelectorAll('.carrusel-slide');
        const dots    = wrapper.querySelectorAll('.dot');
        let actual    = [...slides].findIndex(s => s.classList.contains('activo'));

        slides[actual].classList.remove('activo');
        dots[actual].classList.remove('activo');

        actual = (actual + direccion + slides.length) % slides.length;

        slides[actual].classList.add('activo');
        dots[actual].classList.add('activo');
    }