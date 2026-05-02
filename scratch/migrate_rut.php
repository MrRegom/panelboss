<?php
// Configuración manual para evitar el error de dependencias
$host = 'localhost';
$db   = 'panelboss';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     // Verificar si la columna existe
     $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'rut'");
     if (!$stmt->fetch()) {
         $pdo->exec("ALTER TABLE users ADD COLUMN rut VARCHAR(20) AFTER name");
         $pdo->exec("CREATE UNIQUE INDEX idx_rut ON users(rut)");
         echo "✅ Columna 'rut' agregada con éxito.\n";
         
         // Seteamos un RUT por defecto para el admin (puedes cambiarlo luego)
         $pdo->exec("UPDATE users SET rut = '12345678-5' WHERE email = 'admin@admin.cl'");
         echo "✅ RUT de administrador seteado a '12345678-5' por defecto.\n";
     } else {
         echo "ℹ️ La columna 'rut' ya existe.\n";
     }
} catch (\PDOException $e) {
     echo "❌ ERROR: " . $e->getMessage() . "\n";
}
