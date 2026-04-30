<?php
/**
 * save_lead.php — Controlador de Captación de Prospectos
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = strip_tags(trim($_POST['nombre']   ?? ''));
    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $whatsapp = strip_tags(trim($_POST['whatsapp'] ?? ''));

    if (!empty($email)) {
        // 1. Notificación por Correo (Mejorada V35)
        $to      = "reltzerspa@gmail.com";
        $subject = "=?UTF-8?B?".base64_encode("🔥 NUEVO PROSPECTO: CajaYa Elite")."?=";
        
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

        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: CajaYa Elite <webmaster@cajaya.cl>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $result = mail($to, $subject, $message, $headers);
        
        // Log de depuración para el Senior (V36)
        file_put_contents(__DIR__ . '/mail_debug.log', date("[Y-m-d H:i:s] ") . "Mail sent to $to. Result: " . ($result ? "OK" : "FAIL") . "\n", FILE_APPEND);

        // 2. Respaldo Local (JSON) - Seguridad ante fallos de mail
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

        echo json_encode(['status' => 'success']);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error']);
