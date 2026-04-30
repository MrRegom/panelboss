<?php
/**
 * save_lead.php — Controlador Unificado de Captación de Prospectos (V49 - Official DB Sync)
 */

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
    $provider = strip_tags(trim($_POST['provider'] ?? 'manual'));

    if (!empty($email)) {
        // --- 1. PERSISTENCIA EN TABLA OFICIAL 'leads' (V49) ---
        $db_status = "PENDING";
        try {
            $dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
            $pdo = new PDO($dsn, 'postgres', 'Rgomez2025..', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
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
        } catch (PDOException $e) {
            $db_status = "Error DB: " . $e->getMessage();
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
                <h2 style='color: #6A37B7;'>🔥 Nuevo Lead (Panel Oficial)</h2>
                <p><strong>Nombre:</strong> $nombre</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>WhatsApp:</strong> $whatsapp</p>
                <p><strong>Proveedor:</strong> $provider</p>
                <p><strong>Fecha:</strong> " . date("d/m/Y H:i:s") . "</p>
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
