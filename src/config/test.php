<?php
require_once 'mailer.php';
$resultado = enviarCorreoDebug('finishlineheesni@gmail.com', 'Test', '<p>Hola</p>');
var_dump($resultado);