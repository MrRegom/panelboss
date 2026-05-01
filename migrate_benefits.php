<?php
require_once __DIR__ . '/src/Config/Database.php';
use App\Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    $benefits = [
        'mensual' => "Integración Boleta SII\nCatálogo Maestro (+20k Prod)\n1 Caja de Venta\nSoporte Estándar\nFuncionamiento Offline",
        'lifetime' => "Pago Único de por Vida\nIntegración Boleta SII\nCatálogo Maestro (+20k Prod)\nMulti-sucursal Élite\nAPI Pro Acceso Total\nConsultoría Técnica",
        'empresa' => "Solución a Medida\nMulti-sucursal Ilimitada\nConsultoría de Negocios\nDesarrollo de Funciones\nSoporte VIP 24/7\nCapacitación Personal"
    ];

    foreach ($benefits as $slug => $desc) {
        $stmt = $db->prepare("UPDATE subscription_plans SET description = ? WHERE slug = ?");
        $stmt->execute([$desc, $slug]);
        echo "✅ Beneficios del plan [$slug] actualizados.\n";
    }

    echo "\n🚀 ¡Migración completada! Ya puedes borrar este archivo y refrescar el panel.";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
