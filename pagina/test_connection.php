<?php
require 'api/Config/Database.php';
$db = App\Config\Database::getConnection();
var_dump($db);
