<?php
/**
 * admin_leads.php — Consola de Gestión de Prospectos CajaYa Elite
 */
$logPath = __DIR__ . '/leads_log.json';
$leads = [];
if (file_exists($logPath)) {
    $leads = json_decode(file_get_contents($logPath), true) ?? [];
}
// Invertir para ver los más recientes primero
$leads = array_reverse($leads);
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
        h1 { font-family: 'Outfit'; font-size: 2.5rem; margin-bottom: 30px; color: var(--primary); }
        .stats { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card); padding: 20px; border-radius: 15px; flex: 1; border: 1px solid rgba(255,255,255,0.1); }
        .stat-card h3 { margin: 0; opacity: 0.6; font-size: 0.9rem; }
        .stat-card p { margin: 10px 0 0; font-size: 2rem; font-weight: 700; font-family: 'Outfit'; }
        table { width: 100%; border-collapse: collapse; background: var(--card); border-radius: 15px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); }
        th { background: rgba(255,255,255,0.05); padding: 20px; text-align: left; font-family: 'Outfit'; color: var(--primary); }
        td { padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .btn-wa { background: #25D366; color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-wa:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3); }
        .empty { text-align: center; padding: 100px; opacity: 0.5; }
    </style>
</head>
<body>
    <h1>🚀 Panel de Prospectos Élite</h1>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Total de Leads</h3>
            <p><?php echo count($leads); ?></p>
        </div>
        <div class="stat-card">
            <h3>Hoy</h3>
            <p><?php echo count(array_filter($leads, function($l){ return strpos($l['fecha'], date('Y-m-d')) !== false; })); ?></p>
        </div>
    </div>

    <?php if (empty($leads)): ?>
        <div class="empty">
            <i class="fa-solid fa-ghost style="font-size: 4rem; margin-bottom: 20px;"></i>
            <p>Aún no hay prospectos capturados.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><?php echo date('d/m H:i', strtotime($lead['fecha'])); ?></td>
                        <td style="font-weight:600;"><?php echo htmlspecialchars($lead['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($lead['email']); ?></td>
                        <td><?php echo htmlspecialchars($lead['whatsapp']); ?></td>
                        <td>
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $lead['whatsapp']); ?>" target="_blank" class="btn-wa">
                                <i class="fa-brands fa-whatsapp"></i> Contactar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
