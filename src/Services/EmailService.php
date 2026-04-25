<?php
namespace App\Services;

// Forzar carga manual (Guerilla Fix)
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Repositories\SettingRepository;

class EmailService {
    public static function sendLicenseKey(string $toEmail, string $userName, string $licenseKey) {
        $repo = new SettingRepository();
        $downloadUrl = $repo->get('download_url') ?? 'https://cajaya.cl/LumarePOS-Setup-1.0.0.exe';
        
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
            $mail->Subject = "🔑 Tu acceso a CajaYa Pro";
            
            $year = date('Y');
            $mail->Body = "
                <div style='background: #f4f7fa; padding: 30px 10px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif;'>
                    <center>
                        <div style='max-width: 480px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;'>
                            
                            <!-- Header Compacto -->
                            <div style='padding: 25px 20px 15px 20px; text-align: center;'>
                                <img src='https://cajaya.cl/assets/logo.png' alt='CajaYa' style='width: 140px; height: auto; margin-bottom: 15px;'>
                                <div style='height: 1px; background: #f1f5f9; width: 80%; margin: 0 auto;'></div>
                            </div>

                            <!-- Cuerpo del Mensaje -->
                            <div style='padding: 0 35px 30px 35px; text-align: left;'>
                                <h2 style='color: #0f172a; font-size: 20px; font-weight: 700; margin: 0 0 10px 0; text-align: center;'>¡Todo listo, $userName!</h2>
                                <p style='color: #64748b; font-size: 14px; line-height: 1.5; margin: 0 0 25px 0; text-align: center;'>Tu sistema POS ha sido configurado correctamente.</p>
                                
                                <!-- Zona de Licencia - Minimalista -->
                                <div style='background: #f8fafc; border-radius: 12px; padding: 25px 15px; text-align: center; margin-bottom: 25px; border: 1px dashed #cbd5e1;'>
                                    <span style='font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;'>Llave de Activación</span>
                                    <div style='font-family: monospace; font-size: 24px; color: #2563eb; font-weight: 800; margin-top: 5px;'>$licenseKey</div>
                                </div>
                                
                                <!-- Botón de Acción -->
                                <div style='text-align: center; margin-bottom: 30px;'>
                                    <a href='$downloadUrl' style='background: #0f172a; color: #ffffff; padding: 14px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block;'>
                                        Descargar Instalador
                                    </a>
                                </div>

                                <div style='font-size: 13px; color: #94a3b8; line-height: 1.4;'>
                                    <strong>¿Cómo empezar?</strong> Abre el programa e ingresa la llave cuando se te solicite. Si necesitas ayuda, nuestro equipo está a un clic de distancia.
                                </div>
                            </div>
                            
                            <!-- Footer Sutil -->
                            <div style='background: #fcfdfe; padding: 20px; text-align: center; border-top: 1px solid #f1f5f9;'>
                                <p style='font-size: 11px; color: #94a3b8; margin: 0;'>© $year CajaYa POS • Sistema de Ventas Profesional</p>
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
