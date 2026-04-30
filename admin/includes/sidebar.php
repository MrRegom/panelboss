<!-- Minimalist Microsoft-Style Sidebar -->
<aside class="app-sidebar shadow-sm" data-bs-theme="dark" style="width: 260px; background: #09090b; border-right: 1px solid rgba(255,255,255,0.05);">
    <div class="sidebar-brand py-4 px-4">
        <a href="./index.php" class="brand-link border-0 d-flex align-items-center">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 28px; width: auto; filter: drop-shadow(0 0 10px rgba(139, 92, 246, 0.3));">
        </a>
    </div>

    <div class="sidebar-wrapper px-3">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column gap-1">
                <li class="nav-header x-small text-muted mb-2 px-3">GENERAL</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header x-small text-muted mb-2 px-3 mt-4">OPERACIONES</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-group"></i>
                        <p>Prospectos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./companies.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-building-user"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./licenses.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-key"></i>
                        <p>Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./planes.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'planes.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-tags"></i>
                        <p>Gestión de Planes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./ayuda.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-book-bookmark text-primary"></i>
                        <p>Documentación API</p>
                    </a>
                </li>

                <li class="nav-header x-small text-muted mb-2 px-3 mt-4">SISTEMA</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-shield-halved"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-sliders"></i>
                        <p>Ajustes</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="mt-auto p-4">
        <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255,255,255,0.05);">
            <p class="x-small text-muted mb-0" style="font-size: 0.65rem;">SISTEMA ACTIVO</p>
            <p class="small fw-bold text-white mb-0">CajaYa Pro v2.4</p>
        </div>
    </div>
</aside>
