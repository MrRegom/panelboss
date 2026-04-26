<?php
header('Content-Type: text/plain');
echo "--- ENV ---\n";
print_r($_ENV);
echo "\n--- SERVER ---\n";
print_r($_SERVER);
echo "\n--- GETENV ---\n";
echo "DB_NAME: " . getenv('DB_NAME') . "\n";
echo "DB_PORT: " . getenv('DB_PORT') . "\n";
