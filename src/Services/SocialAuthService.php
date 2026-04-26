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
     * y le asigna una licencia demo si es nuevo o si le falta.
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

        $expiresAt = date('Y-m-d', strtotime('+30 days')); // Demo de 30 días

        if (!$lead) {
            // 2. Es un usuario NUEVO -> Crear Lead
            $demoKey = 'CJYA-DEMO-' . strtoupper(bin2hex(random_bytes(4)));
            
            $insert = $this->db->prepare("
                INSERT INTO leads (email, full_name, provider, provider_id, avatar_url, demo_license_key)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $insert->execute([$email, $fullName, $provider, $providerId, $avatar, $demoKey]);
            
            // Recargar para obtener el ID real
            $stmt->execute([$email]);
            $lead = $stmt->fetch();

            // 3. Crear la licencia físicamente
            $this->licenseRepo->create($demoKey, 'demo', $expiresAt, null);
            $isNew = true;
        } else {
            // Usuario existente -> Verificar si la licencia existe en la tabla maestra
            $demoKey = $lead['demo_license_key'];
            
            $stmtLicense = $this->db->prepare("SELECT id FROM licenses WHERE license_key = ?");
            $stmtLicense->execute([$demoKey]);
            if (!$stmtLicense->fetch()) {
                // Sincronización tardía: Crear licencia si no existía
                $this->licenseRepo->create($demoKey, 'demo', $expiresAt, null);
            }

            // Actualizar último login
            $update = $this->db->prepare("UPDATE leads SET last_login = CURRENT_TIMESTAMP WHERE email = ?");
            $update->execute([$email]);
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
