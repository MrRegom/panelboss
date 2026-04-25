<?php
namespace App\Controllers;

use App\Services\RegistrationService;
use Exception;

class RegisterController {
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService) {
        $this->registrationService = $registrationService;
    }

    public function handleRequest(): void {
        // Orquestador de la petición HTTP
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método HTTP no permitido.']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $email = trim($input['email'] ?? '');

        if (empty($email)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'El correo electrónico es obligatorio.']);
            return;
        }

        try {
            $this->registrationService->registerAccount($email);
            
            http_response_code(201);
            echo json_encode([
                'success' => true, 
                'message' => '¡Cuenta creada con éxito! El sistema Postgres automatizó tu entorno (Tenant).'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
