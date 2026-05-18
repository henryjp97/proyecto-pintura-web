<?php
function enviarCorreo(string $destinatario, string $asunto, string $cuerpoHtml): bool {
    $apiKey = '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';

    $datos = [
        'sender'     => ['name' => 'FinishLine', 'email' => 'finishlineheesni@gmail.com'],
        'to'         => [['email' => $destinatario]],
        'subject'    => $asunto,
        'htmlContent'=> $cuerpoHtml
    ];

    $ch = curl_init('https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'api-key: ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));

    $respuesta = curl_exec($ch);
    $codigo    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $codigo === 201;
}