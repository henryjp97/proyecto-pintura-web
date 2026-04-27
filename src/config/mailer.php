<?php
// src/config/mailer.php
// Configuración centralizada de PHPMailer con Gmail SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

function crearMailer(): PHPMailer {
    $mail = new PHPMailer(true); // true = lanza excepciones en vez de warnings

    // ── Configuración SMTP ──────────────────────────────
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('MAIL_USER');     // tu correo Gmail
    $mail->Password   = getenv('MAIL_PASS');     // contraseña de aplicación Google
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // ── Remitente ───────────────────────────────────────
    $mail->setFrom(getenv('MAIL_USER'), 'FinishLine');
    $mail->CharSet = 'UTF-8';

    return $mail;
}
