<?php
/**
 * save_lead.php — Controlador de Captación de Prospectos CajaYa Elite (V46)
 */

// 1. Declaraciones Top-Level (Obligatorio para que no se cuelgue)
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = strip_tags(trim($_POST['nombre']   ?? ''));
    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $whatsapp = strip_tags(trim($_POST['whatsapp'] ?? ''));

    if (!empty($email)) {
        $mail = new PHPMailer(true);
        $result_smtp = "FAIL";

        try {
            // Configuración del Servidor (Copiada de EmailService.php)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'reltzerspa@gmail.com';
            $mail->Password   = 'eism hymp wnzq maqj'; // Credencial Maestra
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->Timeout    = 20; // 20 segundos de espera

            // Destinatarios
            $mail->setFrom('reltzerspa@gmail.com', 'CajaYa Elite');
            $mail->addAddress('reltzerspa@gmail.com', 'Admin CajaYa');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = "🚀 NUEVO PROSPECTO: $nombre (CajaYa Elite)";
            
            $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='background: #6A37B7; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                    <h2 style='margin: 0;'>🔥 ¡Nuevo Lead Capturado!</h2>
                </div>
                <div style='padding: 30px; border: 1px solid #eee; border-radius: 0 0 10px 10px;'>
                    <p><strong>Nombre:</strong> $nombre</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>WhatsApp:</strong> $whatsapp</p>
                    <p><strong>Fecha:</strong> " . date("d/m/Y H:i:s") . "</p>
                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #999; text-align: center;'>Notificación generada por CajaYa Landing V46.</p>
                </div>
            </body>
            </html>";

            $mail->send();
            $result_smtp = "OK";
        } catch (Exception $e) {
            $result_smtp = "Error: " . $mail->ErrorInfo;
        }
        
        // Log de depuración (V46)
        @file_put_contents(__DIR__ . '/mail_debug.log', date("[Y-m-d H:i:s] ") . "V46 Result: $result_smtp\n", FILE_APPEND);

        // Respaldo Local (JSON)
        $leadData = [
            'nombre'   => $nombre,
            'email'    => $email,
            'whatsapp' => $whatsapp,
            'fecha'    => date("Y-m-d H:i:s")
        ];
        
        $logPath = __DIR__ . '/leads_log.json';
        $currentLeads = [];
        if (file_exists($logPath)) {
            $currentLeads = json_decode(file_get_contents($logPath), true) ?? [];
        }
        $currentLeads[] = $leadData;
        @file_put_contents($logPath, json_encode($currentLeads, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success', 'smtp' => $result_smtp]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error']);
