<?php
require_once 'src/Config/Database.php';
header('Content-Type: text/plain');

try {
    $db = App\Config\Database::getConnection();
    
    $key = 'CJYA-DEMO-E11A0785';
    
    echo "Buscando licencia $key en tabla 'licenses'...\n";
    $stmt = $db->prepare("SELECT * FROM licenses WHERE license_key = ?");
    $stmt->execute([$key]);
    $license = $stmt->fetch();
    
    if ($license) {
        echo "¡ENCONTRADA!\n";
        print_r($license);
    } else {
        echo "NO ENCONTRADA en la tabla 'licenses'.\n";
        
        echo "\nBuscando en tabla 'leads'...\n";
        $stmt = $db->prepare("SELECT * FROM leads WHERE demo_license_key = ?");
        $stmt->execute([$key]);
        $lead = $stmt->fetch();
        
        if ($lead) {
            echo "¡ENCONTRADA en 'leads'!\n";
            print_r($lead);
            echo "\nSugerencia: La licencia existe como prospecto pero no se sincronizó a la tabla de licencias activas.";
        } else {
            echo "Tampoco existe en 'leads'.";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
