<?php
$dsn = "pgsql:host=localhost;port=5433;dbname=postgres";
$user = "postgres";
$pass = "Rgomez2025..";
try {
    $db = new PDO($dsn, $user, $pass);
    $tables = $db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in postgres: " . implode(", ", $tables) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
