<?php
/**
 * admin/includes/bootstrap.php — Inicialización robusta para el Panel Administrativo
 */

$baseDir = __DIR__;
// Buscamos hacia arriba hasta encontrar la carpeta vendor
while ($baseDir !== dirname($baseDir) && !file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname($baseDir);
}

if (!file_exists($baseDir . '/vendor/autoload.php')) {
    die("Error Crítico: No se pudo localizar la raíz del proyecto (vendor no encontrado).");
}

if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', $baseDir);
}

// Cargar Autoload de Composer
require_once PROJECT_ROOT . '/vendor/autoload.php';

// Los namespaces App\ se cargan automáticamente desde src/ gracias a PSR-4
