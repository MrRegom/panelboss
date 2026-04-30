<?php
/**
 * save_lead.php — Controlador de Captación de Prospectos
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = strip_tags(trim($_POST['nombre']   ?? ''));
    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $whatsapp = strip_tags(trim($_POST['whatsapp'] ?? ''));

    if (!empty($email)) {
        // 1. Notificación por Correo
        $to      = "reltzerspa@gmail.com";
        $subject = "🔥 NUEVO INTERESADO: CajaYa Elite";
        $message = "Has recibido un nuevo prospecto interesado en el lanzamiento de CajaYa Elite:\n\n";
        $message .= "Nombre: $nombre\n";
        $message .= "Email: $email\n";
        $message .= "WhatsApp: $whatsapp\n";
        $message .= "Fecha: " . date("d/m/Y H:i:s") . "\n";
        
        $headers = "From: webmaster@cajaya.cl" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        @mail($to, $subject, $message, $headers);

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
