<?php
/**
 * save_lead.php — Controlador Unificado de Captación de Prospectos (V50 - Native Connection)
 */

// 1. Carga de dependencias oficiales del proyecto
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

use App\Config\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = strip_tags(trim($_POST['nombre']   ?? ''));
    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $whatsapp = strip_tags(trim($_POST['whatsapp'] ?? ''));
    $provider = strip_tags(trim($_POST['provider'] ?? 'manual'));

    if (!empty($email)) {
        // --- 1. PERSISTENCIA USANDO CONEXIÓN OFICIAL (V50) ---
        $db_status = "PENDING";
        try {
            $pdo = Database::getConnection(); // Uso de la conexión maestra del proyecto
            
            $sql = "INSERT INTO public.leads (full_name, email, whatsapp, provider) 
                    VALUES (:nombre, :email, :whatsapp, :provider)
                    ON CONFLICT (email) DO UPDATE SET 
                        full_name = EXCLUDED.full_name, 
                        whatsapp = EXCLUDED.whatsapp, 
                        last_login = now();";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'   => $nombre,
                ':email'    => $email,
                ':whatsapp' => $whatsapp,
                ':provider' => $provider
            ]);
            $db_status = "OK";
        } catch (\Exception $e) {
            $db_status = "Error DB: " . $e->getMessage();
            error_log("CAJAYA V50 ERROR: " . $e->getMessage());
        }

        // --- 2. NOTIFICACIÓN POR CORREO ---
        $mail = new PHPMailer(true);
        $result_smtp = "FAIL";
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'reltzerspa@gmail.com';
            $mail->Password   = 'eism hymp wnzq maqj'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('reltzerspa@gmail.com', 'CajaYa Elite');
            $mail->addAddress('reltzerspa@gmail.com', 'Admin CajaYa');

            $mail->isHTML(true);
            $mail->Subject = "🚀 NUEVO PROSPECTO: $nombre";
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <h2 style='color: #6A37B7;'>🔥 Nuevo Lead Registrado</h2>
                <p><strong>Nombre:</strong> $nombre</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>WhatsApp:</strong> $whatsapp</p>
                <p><strong>DB Sync:</strong> $db_status</p>
            </div>";

            $mail->send();
            $result_smtp = "OK";
        } catch (Exception $e) {
            $result_smtp = "Error: " . $mail->ErrorInfo;
        }

        echo json_encode(['status' => 'success', 'db' => $db_status, 'smtp' => $result_smtp]);
        exit;
    }
}
http_response_code(400);
echo json_encode(['status' => 'error']);
