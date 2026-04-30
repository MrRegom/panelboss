<?php
$dsn = "pgsql:host=localhost;port=5433;dbname=cajaya";
$pdo = new PDO($dsn, 'postgres', 'Rgomez2025..');
$stmt = $pdo->query("SELECT * FROM public.profiles LIMIT 5");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
