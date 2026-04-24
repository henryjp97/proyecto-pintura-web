const mensaje = document.getElementById('mensaje');
const contador = document.getElementById('char-count');

    mensaje.addEventListener('input', function() {

    const longitud = mensaje.value.length;
    contador.textContent = `${longitud} / 400 caracteres`;
    
    if (longitud >= 350) { //cambio de color cuando pase de 349
        contador.style.color = '#FF6B6B';
    } else {
        contador.style.color = '#718096';
    }
});