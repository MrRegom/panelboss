<?php
// Punto de entrada de la API (Front Controller)

// 1. Autocargador manual simple (simulando PSR-4 sin Composer)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\RegisterController;
use App\Services\RegistrationService;
use App\Repositories\UserRepository;

// 2. Inyección de Dependencias (DI) manual - Clean Architecture
$repository = new UserRepository();
$service = new RegistrationService($repository);
$controller = new RegisterController($service);

// 3. Ejecutar la petición
$controller->handleRequest();
