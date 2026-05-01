<!-- CajaYa Standard Pro Sidebar (V110) -->
<aside class="app-sidebar shadow">
    <div class="sidebar-brand">
        <a href="./index.php" class="brand-link border-0 d-flex align-items-center justify-content-center w-100 py-3">
            <!-- Logo original CajaYa (Color) -->
            <img src="img/logo.png?v=110" alt="CajaYa" style="height: 34px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-3">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-chart-pie"></i>
                        <p>Vista General</p>
                    </a>
                </li>

                <li class="nav-header">GESTIÓN COMERCIAL</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-group"></i>
                        <p>Prospectos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./companies.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-building"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./licenses.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-file-contract"></i>
                        <p>Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-cubes"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>

                <li class="nav-header">ADMINISTRACIÓN</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-users-gear"></i>
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

    <div class="p-3 mt-auto border-top border-white border-opacity-5 text-center">
        <div class="x-small fw-semibold text-white opacity-25">CajaYa Enterprise v2.6</div>
    </div>
</aside>
