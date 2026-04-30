<?php
$dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
$pdo = new PDO($dsn, 'postgres', 'Rgomez2025..');
$tables = ['profiles', 'users', 'tenants', 'prospectos', 'companies'];
foreach($tables as $table) {
    echo "--- Buscando en $table ---\n";
    $stmt = $pdo->query("SELECT * FROM public.$table WHERE full_name ILIKE '%Mindy%' OR email ILIKE '%Mindy%' OR name ILIKE '%Mindy%'");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
}
