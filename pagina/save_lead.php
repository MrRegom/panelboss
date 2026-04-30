<?php
/**
 * save_lead.php — Controlador de Captación de Prospectos CajaYa Elite (V47 - DB Ready)
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

    if (!empty($email)) {
        // --- 1. PERSISTENCIA EN BASE DE DATOS (V47) ---
        $db_status = "PENDING";
        try {
            $dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
            $pdo = new PDO($dsn, 'postgres', 'Rgomez2025..', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $sql = "INSERT INTO public.prospectos (nombre, email, whatsapp) 
                    VALUES (:nombre, :email, :whatsapp)
                    ON CONFLICT (email) DO UPDATE SET 
                        nombre = EXCLUDED.nombre, 
                        whatsapp = EXCLUDED.whatsapp, 
                        fecha = now();";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'   => $nombre,
                ':email'    => $email,
                ':whatsapp' => $whatsapp
            ]);
            $db_status = "OK";
        } catch (PDOException $e) {
            $db_status = "Error DB: " . $e->getMessage();
            error_log("Error DB Prospectos: " . $e->getMessage());
        }

        // --- 2. NOTIFICACIÓN POR CORREO (PHPMailer V46) ---
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
            $mail->Timeout    = 20;

            $mail->setFrom('reltzerspa@gmail.com', 'CajaYa Elite');
            $mail->addAddress('reltzerspa@gmail.com', 'Admin CajaYa');

            $mail->isHTML(true);
            $mail->Subject = "🚀 NUEVO PROSPECTO: $nombre (CajaYa Elite)";
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333;'>
                <div style='background: #6A37B7; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                    <h2 style='margin: 0;'>🔥 ¡Nuevo Lead Capturado!</h2>
                </div>
                <div style='padding: 30px; border: 1px solid #eee; border-radius: 0 0 10px 10px;'>
                    <p><strong>Nombre:</strong> $nombre</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>WhatsApp:</strong> $whatsapp</p>
                    <p><strong>Estado DB:</strong> $db_status</p>
                    <p><strong>Fecha:</strong> " . date("d/m/Y H:i:s") . "</p>
                </div>
            </div>";

            $mail->send();
            $result_smtp = "OK";
        } catch (Exception $e) {
            $result_smtp = "Error: " . $mail->ErrorInfo;
        }
        
        // Log de depuración
        @file_put_contents(__DIR__ . '/mail_debug.log', date("[Y-m-d H:i:s] ") . "V47 - DB: $db_status | SMTP: $result_smtp\n", FILE_APPEND);

        // 3. RESPALDO EN JSON (Seguridad Senior)
        $leadData = ['nombre'=>$nombre, 'email'=>$email, 'whatsapp'=>$whatsapp, 'fecha'=>date("Y-m-d H:i:s")];
        $logPath = __DIR__ . '/leads_log.json';
        $currentLeads = file_exists($logPath) ? json_decode(file_get_contents($logPath), true) ?? [] : [];
        $currentLeads[] = $leadData;
        @file_put_contents($logPath, json_encode($currentLeads, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success', 'db' => $db_status, 'smtp' => $result_smtp]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error']);
