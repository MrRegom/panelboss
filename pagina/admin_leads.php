<?php
/**
 * admin_leads.php — Consola de Gestión de Prospectos CajaYa Elite (V47 - DB Powered)
 */

$leads = [];
$db_error = null;

try {
    // Intento de conexión a PostgreSQL
    $dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
    $pdo = new PDO($dsn, 'postgres', 'Rgomez2025..', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    $stmt = $pdo->query("SELECT * FROM public.prospectos ORDER BY fecha DESC");
    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $db_error = "Error DB: " . $e->getMessage();
    // Fallback al JSON si la DB falla
    $logPath = __DIR__ . '/leads_log.json';
    if (file_exists($logPath)) {
        $leads = json_decode(file_get_contents($logPath), true) ?? [];
        $leads = array_reverse($leads);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Prospectos — CajaYa Elite</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #6A37B7; --bg: #0D0B14; --card: #1A1726; --text: #ffffff; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        h1 { font-family: 'Outfit'; font-size: 2.5rem; margin: 0; color: var(--primary); }
        .badge-db { background: #2563eb; color: white; padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .stats { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card); padding: 25px; border-radius: 20px; flex: 1; border: 1px solid rgba(255,255,255,0.05); transition: 0.3s; }
        .stat-card:hover { border-color: var(--primary); transform: translateY(-5px); }
        .stat-card h3 { margin: 0; opacity: 0.5; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card p { margin: 10px 0 0; font-size: 2.5rem; font-weight: 700; font-family: 'Outfit'; color: #fff; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; margin-top: 20px; }
        th { padding: 15px 20px; text-align: left; font-family: 'Outfit'; color: rgba(255,255,255,0.4); font-weight: 500; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        tr { background: var(--card); transition: 0.3s; }
        tr:hover { transform: scale(1.01); background: rgba(255,255,255,0.03); }
        td { padding: 20px; border-top: 1px solid rgba(255,255,255,0.02); }
        td:first-child { border-radius: 15px 0 0 15px; }
        td:last-child { border-radius: 0 15px 15px 0; }
        .btn-wa { background: #25D366; color: white; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-wa:hover { background: #1eb954; transform: translateY(-2px); box-shadow: 0 5px 20px rgba(37, 211, 102, 0.2); }
        .status-pill { padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; background: rgba(106, 55, 183, 0.2); color: var(--primary); border: 1px solid rgba(106, 55, 183, 0.3); }
        .error-alert { background: #ef444422; border: 1px solid #ef444444; color: #f87171; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 Prospectos Élite <span class="badge-db">PostgreSQL Active</span></h1>
        <div style="opacity: 0.5; font-size: 12px; font-family: monospace;">Panelboss v4.7</div>
    </div>

    <?php if ($db_error): ?>
        <div class="error-alert">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $db_error; ?> - Mostrando datos de respaldo (JSON).
        </div>
    <?php endif; ?>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Audiencia Total</h3>
            <p><?php echo count($leads); ?></p>
        </div>
        <div class="stat-card">
            <h3>Conversión Hoy</h3>
            <p><?php echo count(array_filter($leads, function($l){ return strpos($l['fecha'] ?? $l['date'], date('Y-m-d')) !== false; })); ?></p>
        </div>
        <div class="stat-card">
            <h3>Nuevos</h3>
            <p><?php echo count(array_filter($leads, function($l){ return ($l['status'] ?? 'nuevo') === 'nuevo'; })); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Llegada</th>
                <th>Nombre del Prospecto</th>
                <th>Canal de Contacto</th>
                <th>WhatsApp</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leads as $lead): ?>
                <tr>
                    <td style="opacity:0.6; font-size:12px;">
                        <?php echo date('d M, H:i', strtotime($lead['fecha'] ?? $lead['date'])); ?>
                    </td>
                    <td style="font-weight:700; font-family:'Outfit'; font-size:1.1rem;">
                        <?php echo htmlspecialchars($lead['nombre']); ?>
                    </td>
                    <td>
                        <div style="font-size:13px; font-weight:600;"><?php echo htmlspecialchars($lead['email']); ?></div>
                        <div style="font-size:10px; opacity:0.5;">Verificado via Landing</div>
                    </td>
                    <td style="font-family:monospace; font-weight:700;">
                        <?php echo htmlspecialchars($lead['whatsapp']); ?>
                    </td>
                    <td>
                        <span class="status-pill"><?php echo strtoupper($lead['status'] ?? 'nuevo'); ?></span>
                    </td>
                    <td>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $lead['whatsapp']); ?>" target="_blank" class="btn-wa">
                            <i class="fa-brands fa-whatsapp"></i> Chat Directo
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
