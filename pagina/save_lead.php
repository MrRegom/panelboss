<?php
/**
 * save_lead.php — Controlador de Captación de Prospectos
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = strip_tags(trim($_POST['nombre']   ?? ''));
    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $whatsapp = strip_tags(trim($_POST['whatsapp'] ?? ''));

    if (!empty($email)) {
        // --- MOTOR SMTP DIRECTO (V43) ---
        $smtp_host = "ssl://smtp.gmail.com";
        $smtp_port = 465;
        $smtp_user = "reltzerspa@gmail.com";
        $smtp_pass = "Reltzer2026.."; // RECUERDA: Si falla, usa una 'App Password' de Google

        $to      = "reltzerspa@gmail.com";
        $subject = "🔥 NUEVO PROSPECTO: CajaYa Elite";
        
        $message = "
        <html>
        <head><title>Nuevo Prospecto</title></head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='background: #6A37B7; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;'>
                <h2 style='margin: 0;'>🚀 ¡Nuevo Lead Capturado!</h2>
            </div>
            <div style='padding: 30px; border: 1px solid #eee; border-radius: 0 0 10px 10px;'>
                <p><strong>Nombre:</strong> $nombre</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>WhatsApp:</strong> $whatsapp</p>
                <p><strong>Fecha:</strong> " . date("d/m/Y H:i:s") . "</p>
            </div>
        </body>
        </html>";

        // Función SMTP Local para no depender de librerías externas
        function sendSMTP($to, $subject, $message, $host, $port, $user, $pass) {
            $socket = fsockopen($host, $port, $errno, $errstr, 15);
            if (!$socket) return "Error Socket: $errstr";
            
            $res = fgets($socket, 256);
            fputs($socket, "EHLO " . $_SERVER['HTTP_HOST'] . "\r\n");
            $res = fgets($socket, 256);
            fputs($socket, "AUTH LOGIN\r\n");
            $res = fgets($socket, 256);
            fputs($socket, base64_encode($user) . "\r\n");
            $res = fgets($socket, 256);
            fputs($socket, base64_encode($pass) . "\r\n");
            $res = fgets($socket, 256);
            
            if (strpos($res, '235') === false) return "Auth Failed: " . $res;

            fputs($socket, "MAIL FROM: <$user>\r\n");
            $res = fgets($socket, 256);
            fputs($socket, "RCPT TO: <$to>\r\n");
            $res = fgets($socket, 256);
            fputs($socket, "DATA\r\n");
            $res = fgets($socket, 256);

            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "To: $to\r\n";
            $headers .= "From: CajaYa Elite <$user>\r\n";
            $headers .= "Subject: $subject\r\n\r\n";

            fputs($socket, $headers . $message . "\r\n.\r\n");
            $res = fgets($socket, 256);
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return "OK";
        }

        $result_smtp = sendSMTP($to, $subject, $message, $smtp_host, $smtp_port, $smtp_user, $smtp_pass);
        
        // Log de depuración (V43)
        file_put_contents(__DIR__ . '/mail_debug.log', date("[Y-m-d H:i:s] ") . "SMTP Result: $result_smtp\n", FILE_APPEND);

        // 2. Respaldo Local (JSON) - Seguridad ante fallos
        $leadData = [
            'nombre'   => $nombre,
            'email'    => $email,
            'whatsapp' => $whatsapp,
            'fecha'    => date("Y-m-d H:i:s")
        ];
        
        $logPath = __DIR__ . '/leads_log.json';
        $currentLeads = [];
        if (file_exists($logPath)) {
            $currentLeads = json_decode(file_get_contents($logPath), true) ?? [];
        }
        $currentLeads[] = $leadData;
        file_put_contents($logPath, json_encode($currentLeads, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success', 'smtp' => $result_smtp]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error']);
