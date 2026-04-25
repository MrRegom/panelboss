<?php
namespace App\Services;

// Forzar carga manual (Guerilla Fix)
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';

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

            // Contenido del Correo
            $mail->isHTML(true);
            $mail->Subject = "🔑 Tu Llave de Acceso - CajaYa POS";
            
            $year = date('Y');
            $mail->Body = "
                <div style='background: #f8fafc; padding: 40px 10px; font-family: -apple-system, system-ui, sans-serif;'>
                    <center>
                        <!-- Tarjeta Corporativa Limpia -->
                        <div style='max-width: 480px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);'>
                            
                            <!-- Header Sutil -->
                            <div style='padding: 30px; text-align: left; border-bottom: 1px solid #f1f5f9;'>
                                <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='height: 35px;'>
                            </div>
                            
                            <!-- Contenido Principal -->
                            <div style='padding: 40px 30px; text-align: left;'>
                                <h1 style='color: #0f172a; font-size: 20px; font-weight: 700; margin: 0 0 10px 0;'>Configuración de tu cuenta</h1>
                                <p style='color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 30px;'>Hola <strong>$userName</strong>, bienvenido a CajaYa POS. Tu infraestructura de ventas ya está lista para operar.</p>
                                
                                <!-- Caja de Licencia Elegante -->
                                <div style='background: #f1f5f9; border-radius: 12px; padding: 25px; text-align: center; margin-bottom: 35px;'>
                                    <span style='text-transform: uppercase; letter-spacing: 1px; font-size: 11px; font-weight: 600; color: #64748b; display: block; margin-bottom: 12px;'>Llave de Acceso Maestra</span>
                                    <div style='font-family: \"SF Mono\", monospace; font-size: 22px; color: #2563eb; font-weight: 700; letter-spacing: 1px;'>$licenseKey</div>
                                </div>
                                
                                <!-- Instrucciones -->
                                <div style='margin-bottom: 35px;'>
                                    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                        <tr>
                                            <td style='vertical-align: top; width: 24px; padding-bottom: 15px;'>
                                                <div style='color: #2563eb; font-weight: bold;'>&bull;</div>
                                            </td>
                                            <td style='color: #1e293b; font-size: 14px; padding-bottom: 15px;'>
                                                <strong>Instalación:</strong> Descarga el ejecutable en tu terminal principal.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='vertical-align: top; width: 24px;'>
                                                <div style='color: #2563eb; font-weight: bold;'>&bull;</div>
                                            </td>
                                            <td style='color: #1e293b; font-size: 14px;'>
                                                <strong>Activación:</strong> Vincula tu equipo usando la llave superior.
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <!-- Botón Corporativo -->
                                <div style='text-align: center;'>
                                    <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='background: #0f172a; color: #ffffff; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block;'>
                                        Descargar CajaYa Pro
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Footer Formal -->
                            <div style='background: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;'>
                                <p style='font-size: 12px; color: #94a3b8; margin: 0;'>© $year CajaYa POS System. Todos los derechos reservados.</p>
                                <p style='font-size: 11px; color: #cbd5e1; margin-top: 5px;'>Soporte técnico: reltzerspa@gmail.com</p>
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
