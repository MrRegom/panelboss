<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class RegistrationService {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registerAccount(string $email): void {
        // Reglas de negocio puras
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico es inválido.");
        }

        if ($this->userRepository->emailExists($email)) {
            throw new Exception("Este correo electrónico ya está registrado en CajaYa.");
        }

        // Delegamos al repositorio. La magia del Trigger de Postgres hace el resto.
        if (!$this->userRepository->createUser($email)) {
            throw new Exception("Error interno al crear la cuenta. Intente nuevamente.");
        }
    }
}
