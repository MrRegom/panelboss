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
                <div style='background: #0a0a0c; padding: 30px 10px; font-family: -apple-system, system-ui, sans-serif;'>
                    <center>
                        <!-- Tarjeta Compacta -->
                        <div style='max-width: 460px; background: #16161a; border: 1px solid #2d2d35; border-radius: 28px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.5);'>
                            
                            <!-- Header Minimalista -->
                            <div style='background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); padding: 40px 30px; text-align: center;'>
                                <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='height: 50px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));'>
                                <h1 style='color: #ffffff; font-size: 22px; font-weight: 800; margin: 20px 0 0 0; letter-spacing: -0.5px;'>¡Bienvenido a CajaYa!</h1>
                            </div>
                            
                            <!-- Contenido Focado -->
                            <div style='padding: 35px 30px; text-align: left;'>
                                <p style='color: #a1a1aa; font-size: 14px; margin-bottom: 8px;'>Hola <span style='color: #ffffff; font-weight: 600;'>$userName</span>,</p>
                                <p style='color: #d1d5db; font-size: 15px; line-height: 1.5; margin-bottom: 25px;'>Tu acceso exclusivo ya está disponible. Transforma tu negocio hoy mismo.</p>
                                
                                <!-- Bloque de Llave Maestra -->
                                <div style='background: #0f172a; border: 1px solid #3b82f6; border-radius: 16px; padding: 25px; text-align: center; margin-bottom: 30px; box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.05);'>
                                    <span style='text-transform: uppercase; letter-spacing: 2px; font-size: 10px; font-weight: 700; color: #3b82f6; display: block; margin-bottom: 10px;'>TU LLAVE MAESTRA</span>
                                    <div style='font-family: monospace; font-size: 24px; color: #60a5fa; font-weight: 800; letter-spacing: 2px;'>$licenseKey</div>
                                </div>
                                
                                <!-- Pasos Rápidos -->
                                <div style='margin-bottom: 30px;'>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                        <tr>
                                            <td style='width: 32px; padding-bottom: 15px;'>
                                                <div style='background: #27272a; width: 24px; height: 24px; border-radius: 6px; color: #ffffff; text-align: center; line-height: 24px; font-size: 12px; font-weight: bold;'>1</div>
                                            </td>
                                            <td style='color: #d1d5db; font-size: 14px; padding-bottom: 15px;'>Instala el software en tu PC.</td>
                                        </tr>
                                        <tr>
                                            <td style='width: 32px;'>
                                                <div style='background: #27272a; width: 24px; height: 24px; border-radius: 6px; color: #ffffff; text-align: center; line-height: 24px; font-size: 12px; font-weight: bold;'>2</div>
                                            </td>
                                            <td style='color: #d1d5db; font-size: 14px;'>Activa con tu llave maestra.</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <!-- CTA -->
                                <div style='text-align: center;'>
                                    <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='background: #ffffff; color: #000000; padding: 15px 30px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 15px; display: inline-block; box-shadow: 0 10px 20px rgba(255,255,255,0.1);'>
                                        Descargar Instalador (.exe)
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div style='background: #111114; padding: 20px; text-align: center; border-top: 1px solid #2d2d35;'>
                                <p style='font-size: 11px; color: #52525b; margin: 0;'>© " . date('Y') . " CajaYa POS. Tecnología chilena de alto rendimiento.</p>
                            </div>
                        </div>
                    </center>
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
