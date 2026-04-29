<?php
require 'vendor/autoload.php';
require 'src/Config/Database.php';
$db = App\Config\Database::getConnection();
$plans = $db->query("SELECT slug, price FROM subscription_plans")->fetchAll(PDO::FETCH_ASSOC);
echo "CONTENIDO DE LA BASE DE DATOS:\n";
print_r($plans);
