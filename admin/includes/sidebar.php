<!-- Quantum 2026 Sidebar (V104) -->
<aside class="app-sidebar shadow-lg" data-bs-theme="dark">
    <div class="sidebar-brand py-5 px-4 text-center">
        <a href="./index.php" class="brand-link border-0">
            <img src="img/logo.png?v=98" alt="CajaYa" style="height: 40px; width: auto; filter: drop-shadow(0 0 20px rgba(99, 102, 241, 0.6));">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header small opacity-25 fw-bold px-4 mb-2" style="letter-spacing: 2px;">CORE SYSTEMS</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-house-laptop"></i>
                        <p>Command Center</p>
                    </a>
                </li>

                <li class="nav-header small opacity-25 fw-bold px-4 mb-2 mt-4" style="letter-spacing: 2px;">OPERATIONS</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-crosshairs"></i>
                        <p>Prospectos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./companies.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-city"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./licenses.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-fingerprint"></i>
                        <p>Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./planes.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'planes.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-gem"></i>
                        <p>Planes Elite</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-database"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./ayuda.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-terminal text-primary"></i>
                        <p>Developer Hub</p>
                    </a>
                </li>

                <li class="nav-header small opacity-25 fw-bold px-4 mb-2 mt-4" style="letter-spacing: 2px;">SECURITY</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-gear"></i>
                        <p>Accesos</p>
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

    <div class="p-4 mt-auto">
        <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-primary rounded-circle" style="width: 6px; height: 6px;"></div>
                <span class="x-small opacity-50 fw-bold" style="font-size: 0.6rem;">NODE: CL-SANTIAGO-1</span>
            </div>
            <div class="fw-bold x-small opacity-75">QUANTUM OS v4.0</div>
        </div>
    </div>
</aside>
