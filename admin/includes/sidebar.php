<!-- Premium Microsoft-Style Sidebar (Gold V103) -->
<aside class="app-sidebar shadow-lg" data-bs-theme="dark">
    <div class="sidebar-brand py-4 px-4 text-center">
        <a href="./index.php" class="brand-link border-0">
            <img src="img/logo.png?v=98" alt="CajaYa" style="height: 35px; width: auto; filter: drop-shadow(0 0 15px rgba(99, 102, 241, 0.4));">
        </a>
    </div>

    <div class="sidebar-wrapper px-2">
        <nav class="mt-4">
            <ul class="nav sidebar-menu flex-column gap-1">
                <li class="nav-header small text-white-50 opacity-50 mb-2 px-4">CENTRO DE CONTROL</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-chart-pie"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header small text-white-50 opacity-50 mb-2 px-4 mt-4">OPERACIONES</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-users-viewfinder"></i>
                        <p>Prospectos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./companies.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-building-shield"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./licenses.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-key-skeleton"></i>
                        <p>Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./planes.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'planes.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-layer-group"></i>
                        <p>Planes Comerciales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-cubes"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./ayuda.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-code text-primary"></i>
                        <p>Developer Hub</p>
                    </a>
                </li>

                <li class="nav-header small text-white-50 opacity-50 mb-2 px-4 mt-4">SISTEMA</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-shield"></i>
                        <p>Administradores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-microchip"></i>
                        <p>Configuración</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="mt-auto p-4">
        <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05);">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px; box-shadow: 0 0 10px #10b981;"></div>
                <span class="x-small text-white-50" style="font-size: 0.65rem; letter-spacing: 0.5px;">PROD SERVER</span>
            </div>
            <p class="small fw-bold text-white mb-0">CajaYa Enterprise</p>
            <p class="x-small text-white-50 mb-0" style="font-size: 0.6rem;">v2.5.0-GOLD</p>
        </div>
    </div>
</aside>
