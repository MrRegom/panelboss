<?php
namespace App\Services;

use PDO;
use App\Repositories\LicenseRepository;

class SocialAuthService {
    private \PDO $db;
    private LicenseRepository $licenseRepo;

    public function __construct(\PDO $db) {
        $this->db = $db;
        $this->licenseRepo = new LicenseRepository($db);
    }

    /**
     * Registra o loguea a un usuario desde un proveedor social
     * y le asigna una licencia demo si es nuevo.
     */
    public function handleSocialLogin(array $userData): array {
        $email = $userData['email'];
        $fullName = $userData['name'];
        $provider = $userData['provider'];
        $providerId = $userData['id'];
        $avatar = $userData['picture'] ?? null;

        // 1. Buscar si ya existe el lead
        $stmt = $this->db->prepare("SELECT * FROM leads WHERE email = ?");
        $stmt->execute([$email]);
        $lead = $stmt->fetch();

        if (!$lead) {
            // 2. Es un usuario NUEVO -> Crear Lead
            $demoKey = 'CJYA-DEMO-' . strtoupper(bin2hex(random_bytes(4)));
            
            $insert = $this->db->prepare("
                INSERT INTO leads (email, full_name, provider, provider_id, avatar_url, demo_license_key)
                VALUES (?, ?, ?, ?, ?, ?)
                RETURNING *
            ");
            $insert->execute([$email, $fullName, $provider, $providerId, $avatar, $demoKey]);
            $lead = $insert->fetch();

            // 3. Crear la licencia físicamente en la tabla de licencias para que funcione la App
            // Nota: Aquí podrías asignarle un plan 'demo' de 15 días
            $expiresAt = date('Y-m-d', strtotime('+15 days'));
            $this->licenseRepo->create($demoKey, 'demo', $expiresAt, null);

            $isNew = true;
        } else {
            // Usuario existente -> Actualizar último login
            $update = $this->db->prepare("UPDATE leads SET last_login = CURRENT_TIMESTAMP WHERE email = ?");
            $update->execute([$email]);
            $demoKey = $lead['demo_license_key'];
            $isNew = false;
        }

        return [
            'success' => true,
            'is_new' => $isNew,
            'user' => $lead,
            'license_key' => $demoKey,
            'download_url' => 'https://cajaya.cl/downloads/CajaYa-Setup-1.0.0.exe'
        ];
    }
}
