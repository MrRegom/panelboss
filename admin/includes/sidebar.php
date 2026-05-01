<!-- CajaYa Legacy Sidebar (V109) -->
<aside class="app-sidebar shadow-lg">
    <div class="sidebar-brand">
        <a href="./index.php" class="brand-link border-0 d-flex align-items-center justify-content-center w-100">
            <img src="img/logo.png?v=100" alt="CajaYa" style="height: 32px; width: auto; filter: brightness(0) invert(1);">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-4">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">CENTRAL DE MANDO</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-rocket"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">OPERACIONES</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-tag"></i>
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
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>

                <li class="nav-header">SISTEMA</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-shield-halved"></i>
                        <p>Accesos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-gears"></i>
                        <p>Ajustes</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-4 mt-auto border-top border-white border-opacity-10 text-center">
        <div class="small fw-bold text-white opacity-50">CajaYa | Legacy Edition</div>
    </div>
</aside>
