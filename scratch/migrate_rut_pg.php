<?php
// Configuración Real extraída de Database.php para PostgreSQL
$host   = 'localhost';
$port   = '5433';
$db     = 'cajaya';
$user   = 'postgres';
$pass   = 'Rgomez2025..';

try {
     $dsn = "pgsql:host=$host;port=$port;dbname=$db";
     $pdo = new PDO($dsn, $user, $pass, [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
     ]);
     
     // Verificar si la columna existe en PostgreSQL
     $stmt = $pdo->query("SELECT column_name FROM information_schema.columns WHERE table_name='users' AND column_name='rut'");
     if (!$stmt->fetch()) {
         $pdo->exec("ALTER TABLE users ADD COLUMN rut VARCHAR(20)");
         $pdo->exec("CREATE UNIQUE INDEX idx_rut ON users(rut)");
         echo "✅ Columna 'rut' agregada con éxito en PostgreSQL.\n";
         
         // Seteamos un RUT de prueba para el admin
         $pdo->exec("UPDATE users SET rut = '12345678-5' WHERE email = 'admin@admin.cl'");
         echo "✅ RUT de administrador seteado a '12345678-5' por defecto.\n";
     } else {
         echo "ℹ️ La columna 'rut' ya existe.\n";
     }
} catch (\PDOException $e) {
     echo "❌ ERROR: " . $e->getMessage() . "\n";
}
