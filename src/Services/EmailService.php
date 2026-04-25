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
                <div style='background-color: #f8fafc; padding: 40px 0; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'>
                    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0;'>
                        <!-- Header con Logo -->
                        <div style='background-color: #04010a; padding: 30px; text-align: center;'>
                            <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='height: 50px;'>
                        </div>
                        
                        <!-- Contenido -->
                        <div style='padding: 40px; color: #1e293b;'>
                            <h1 style='color: #0f172a; font-size: 24px; margin-bottom: 20px;'>¡Tu acceso está listo, $userName!</h1>
                            <p style='font-size: 16px; line-height: 1.6;'>Estamos muy emocionados de que formes parte de <strong>CajaYa</strong>. Aquí tienes tu llave maestra para activar tu sistema POS:</p>
                            
                            <div style='background: #f1f5f9; border-radius: 12px; padding: 25px; text-align: center; margin: 30px 0; border: 1px dashed #9333ea;'>
                                <span style='font-family: monospace; font-size: 22px; color: #9333ea; font-weight: bold; letter-spacing: 2px;'>$licenseKey</span>
                            </div>
                            
                            <p style='font-size: 15px; margin-bottom: 25px;'><strong>¿Cómo empezar?</strong> Es muy fácil:</p>
                            
                            <div style='margin-bottom: 30px;'>
                                <div style='margin-bottom: 15px;'>
                                    <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='background-color: #9333ea; color: #ffffff; padding: 14px 28px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block;'>Descargar Instalador Windows</a>
                                </div>
                                <p style='font-size: 14px; color: #64748b;'>Luego de instalar, ingresa tu llave para activar la demo de 15 días.</p>
                            </div>
                            
                            <hr style='border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;'>
                            
                            <p style='font-size: 14px; color: #64748b; text-align: center;'>Si tienes alguna pregunta, nuestro equipo de soporte está listo para ayudarte. ¡Buenas ventas!</p>
                        </div>
                        
                        <!-- Footer -->
                        <div style='background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;'>
                            <p style='font-size: 12px; color: #94a3b8; margin: 0;'>© " . date('Y') . " CajaYa POS. Todos los derechos reservados.</p>
                        </div>
                    </div>
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
