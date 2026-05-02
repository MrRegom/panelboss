<!-- CajaYa Premium Night Sidebar (V111) -->
<aside class="app-sidebar shadow-lg">
    <div class="sidebar-brand">
        <a href="./index.php" class="brand-link border-0 d-flex align-items-center justify-content-center w-100 py-3">
            <!-- Logo original CajaYa (Color) con filtro para fondo oscuro -->
            <img src="img/logo.png?v=114" alt="CajaYa" style="height: 38px; width: auto;">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-4">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">INTELIGENCIA</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>Dashboard Real-Time</p>
                    </a>
                </li>

                <li class="nav-header">GESTIÓN CORE</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-users-viewfinder"></i>
                        <p>Prospectos Cloud</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./companies.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-building-circle-check"></i>
                        <p>Directorio Empresas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./licenses.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-key"></i>
                        <p>Gestión Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-boxes-packing"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>

                <li class="nav-header">SISTEMA & SEGURIDAD</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-shield"></i>
                        <p>Control de Accesos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-gears"></i>
                        <p>Configuración Global</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-4 mt-auto border-top border-white border-opacity-5 text-center">
        <div class="x-small fw-bold text-white-50 opacity-50 mb-1">CajaYa Enterprise</div>
        <div class="x-small text-muted" style="font-size: 0.6rem;">BUILD BY <span class="text-white opacity-75">RELTZER CODERS</span></div>
    </div>
</aside>
