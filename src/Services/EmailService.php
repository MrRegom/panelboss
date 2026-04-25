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
                <div style='background: #f1f5f9; padding: 60px 10px; font-family: -apple-system, system-ui, sans-serif;'>
                    <center>
                        <!-- Logo Destacado (GRANDE) -->
                        <div style='margin-bottom: 40px;'>
                            <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='width: 240px; height: auto;'>
                        </div>

                        <!-- Tarjeta Corporativa Premium -->
                        <div style='max-width: 520px; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);'>
                            
                            <!-- Banner de Bienvenida -->
                            <div style='background: #0f172a; padding: 50px 40px; text-align: center;'>
                                <h1 style='color: #ffffff; font-size: 26px; font-weight: 800; margin: 0; letter-spacing: -1px;'>¡Bienvenido a bordo!</h1>
                                <p style='color: #94a3b8; font-size: 16px; margin: 15px 0 0 0;'>Tu terminal de ventas está lista para despegar.</p>
                            </div>
                            
                            <!-- Contenido Principal -->
                            <div style='padding: 45px 40px; text-align: left;'>
                                <p style='color: #334155; font-size: 16px; line-height: 1.6; margin-bottom: 30px;'>Hola <strong>$userName</strong>,<br><br>Hemos configurado con éxito tu acceso a <strong>CajaYa Pro</strong>. A continuación encontrarás las credenciales maestras para activar tu sistema.</p>
                                
                                <!-- Caja de Licencia Visual -->
                                <div style='background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 20px; padding: 35px 20px; text-align: center; margin-bottom: 40px;'>
                                    <span style='text-transform: uppercase; letter-spacing: 2px; font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 15px;'>LLAVE MAESTRA DE ACTIVACIÓN</span>
                                    <div style='font-family: \"Courier New\", Courier, monospace; font-size: 28px; color: #0284c7; font-weight: 900; letter-spacing: 2px;'>$licenseKey</div>
                                </div>
                                
                                <!-- Guía de Pasos Rápidos -->
                                <div style='margin-bottom: 40px; border-left: 3px solid #e2e8f0; padding-left: 20px;'>
                                    <h3 style='font-size: 14px; color: #0f172a; margin-bottom: 15px;'>PRÓXIMOS PASOS:</h3>
                                    <p style='color: #475569; font-size: 14px; margin-bottom: 10px;'><strong>1. Descarga:</strong> Usa el botón inferior para bajar el instalador oficial.</p>
                                    <p style='color: #475569; font-size: 14px; margin: 0;'><strong>2. Activa:</strong> Pega tu llave maestra al iniciar el software por primera vez.</p>
                                </div>
                                
                                <!-- Botón de Descarga Estilo App Store -->
                                <div style='text-align: center;'>
                                    <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='background: #2563eb; color: #ffffff; padding: 18px 40px; border-radius: 14px; text-decoration: none; font-weight: 700; font-size: 16px; display: inline-block; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);'>
                                        Descargar CajaYa Pro 1.0
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Footer Corporativo -->
                            <div style='background: #f8fafc; padding: 30px; text-align: center; border-top: 1px solid #f1f5f9;'>
                                <p style='font-size: 12px; color: #64748b; margin: 0;'>© $year CajaYa POS System • Chile</p>
                                <p style='font-size: 11px; color: #94a3b8; margin-top: 8px;'>Este es un correo automático, por favor no respondas a esta dirección.</p>
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
