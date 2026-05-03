<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

function crearMailer(): PHPMailer {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('MAIL_USER');// Crearos en .env MAIL_USER=Tu MAIL        MAIL_PASS=TU CONTRASEÑA (La que tienes que buscar en google(no la que usualmente usas))
    $mail->Password   = getenv('MAIL_PASS');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom(getenv('MAIL_USER'), 'FinishLine');
    $mail->CharSet = 'UTF-8';

    return $mail;
}