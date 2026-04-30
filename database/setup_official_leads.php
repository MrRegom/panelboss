<?php
/**
 * setup_official_leads.php — Creacion de tabla oficial unificada (V49)
 */
$host = 'localhost';
$port = '5433';
$dbname = 'cajaya';
$user = 'postgres';
$pass = 'Rgomez2025..';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    $sql = "CREATE TABLE IF NOT EXISTS public.leads (
        id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
        email VARCHAR(255) UNIQUE NOT NULL,
        full_name VARCHAR(255),
        whatsapp VARCHAR(50), -- El campo que faltaba
        provider VARCHAR(50), 
        provider_id VARCHAR(255),
        avatar_url TEXT,
        demo_license_key VARCHAR(50),
        created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
        last_login TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
    );
    CREATE INDEX IF NOT EXISTS idx_leads_email_official ON public.leads(email);";
    
    $pdo->exec($sql);
    echo "¡TABLA OFICIAL 'LEADS' CREADA Y SINCRONIZADA! 🚀";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
