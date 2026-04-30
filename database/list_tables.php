<?php
$dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
$pdo = new PDO($dsn, 'postgres', 'Rgomez2025..');
$stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
while($row = $stmt->fetch()) {
    echo $row['table_name'] . "\n";
}
