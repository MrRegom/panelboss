<?php
$passwords = ['pass', 'Rgomez2025..', 'postgres'];
$host = '127.0.0.1';
$ports = ['5432', '5433', '5434'];
$db   = 'cajaya';
$user = 'postgres';

foreach ($ports as $port) {
    foreach ($passwords as $pass) {
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$db";
            $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            echo "EXITO: Puerto $port, Contraseña '$pass'\n";
            exit;
        } catch (Exception $e) {
            echo "Error P=$port Pass='$pass': " . $e->getMessage() . "\n";
        }
    }
}
echo "NINGUNA_FUNCIONO";
