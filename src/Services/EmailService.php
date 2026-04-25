<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    public static function sendLicenseKey(string $toEmail, string $userName, string $licenseKey) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del Servidor
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'] ?? 587;
            $mail->CharSet    = 'UTF-8';

            // Destinatarios
            $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($toEmail, $userName);

            // Contenido del Correo (HTML elegante)
            $mail->isHTML(true);
            $mail->Subject = "🔑 Tu Llave de Acceso - CajaYa POS";
            
            $mail->Body = "
                <div style='font-family: sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                    <h2 style='color: #9333ea; text-align: center;'>¡Bienvenido a CajaYa!</h2>
                    <p>Hola <strong>$userName</strong>,</p>
                    <p>Gracias por unirte a la nueva era del control de ventas. Aquí tienes tu llave demo para comenzar hoy mismo:</p>
                    
                    <div style='background: #f4f4f4; border: 1px dashed #9333ea; padding: 20px; text-align: center; font-family: monospace; font-size: 24px; color: #0ea5e9; margin: 20px 0;'>
                        $licenseKey
                    </div>
                    
                    <p><strong>¿Qué sigue?</strong></p>
                    <ol>
                        <li>Descarga el instalador desde <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='color: #0ea5e9;'>este enlace</a>.</li>
                        <li>Instala CajaYa en tu PC con Windows.</li>
                        <li>Ingresa esta llave cuando el programa te lo pida.</li>
                    </ol>
                    
                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #999; text-align: center;'>
                        CajaYa POS - El sistema que nunca te deja solo.
                    </p>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error enviando correo: {$mail->ErrorInfo}");
            return false;
        }
    }
}
