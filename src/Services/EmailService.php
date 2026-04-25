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
                <div style='background: #0f172a; background-image: radial-gradient(circle at top right, #1e1b4b, #0f172a); padding: 50px 20px; font-family: \"Inter\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif;'>
                    <div style='max-width: 600px; margin: 0 auto; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);'>
                        
                        <!-- Header / Hero Section -->
                        <div style='background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%); padding: 60px 40px; text-align: center; position: relative;'>
                            <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='height: 65px; margin-bottom: 30px;'>
                            <h1 style='color: #ffffff; font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -0.025em; line-height: 1.2;'>¡Tu futuro comercial comienza aquí!</h1>
                        </div>
                        
                        <!-- Main Content -->
                        <div style='padding: 50px 40px; color: #f1f5f9;'>
                            <p style='font-size: 18px; margin-bottom: 25px; color: #94a3b8;'>Hola <span style='color: #ffffff; font-weight: 600;'>$userName</span>,</p>
                            <p style='font-size: 16px; line-height: 1.7; color: #cbd5e1; margin-bottom: 35px;'>Bienvenido a la plataforma POS más avanzada del mercado. Hemos generado tu llave de acceso exclusiva para que transformes tu negocio desde hoy mismo.</p>
                            
                            <!-- License Card -->
                            <div style='background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(147, 51, 234, 0.3); border-radius: 20px; padding: 40px 20px; text-align: center; margin-bottom: 40px;'>
                                <p style='text-transform: uppercase; letter-spacing: 0.1em; font-size: 12px; font-weight: 700; color: #9333ea; margin-bottom: 15px;'>Tu Llave Maestra Demo</p>
                                <div style='font-family: \"Fira Code\", monospace; font-size: 28px; color: #38bdf8; font-weight: 700; letter-spacing: 3px;'>$licenseKey</div>
                            </div>
                            
                            <!-- Steps / CTA -->
                            <div style='margin-bottom: 40px;'>
                                <h3 style='color: #ffffff; font-size: 18px; margin-bottom: 20px;'>Próximos Pasos:</h3>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                    <tr>
                                        <td style='vertical-align: top; padding-bottom: 20px;'>
                                            <div style='background: #9333ea; width: 28px; height: 28px; border-radius: 50%; color: white; text-align: center; line-height: 28px; font-weight: bold; margin-right: 15px;'>1</div>
                                        </td>
                                        <td style='color: #cbd5e1; font-size: 15px; padding-bottom: 20px;'>
                                            <strong>Descarga la App:</strong> Haz clic en el botón de abajo para obtener el instalador oficial.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='vertical-align: top;'>
                                            <div style='background: #3b82f6; width: 28px; height: 28px; border-radius: 50%; color: white; text-align: center; line-height: 28px; font-weight: bold; margin-right: 15px;'>2</div>
                                        </td>
                                        <td style='color: #cbd5e1; font-size: 15px;'>
                                            <strong>Activa tu Licencia:</strong> Ingresa tu llave al abrir el programa y ¡listo!
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div style='text-align: center; margin-top: 40px;'>
                                <a href='https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe' style='background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); color: #ffffff; padding: 20px 40px; border-radius: 16px; text-decoration: none; font-weight: 700; font-size: 16px; display: inline-block; box-shadow: 0 10px 15px -3px rgba(147, 51, 234, 0.4);'>Descargar CajaYa para Windows</a>
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div style='background: rgba(15, 23, 42, 0.3); padding: 30px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.05);'>
                            <p style='font-size: 13px; color: #64748b; margin-bottom: 10px;'>¿Necesitas ayuda? Responde a este correo o visita nuestro centro de soporte.</p>
                            <p style='font-size: 11px; color: #475569; margin: 0;'>© " . date('Y') . " CajaYa POS System. Ingeniería chilena de clase mundial.</p>
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
