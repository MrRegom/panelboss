<!-- Azure Sidebar (V108) - Microsoft Style -->
<aside class="app-sidebar shadow-sm">
    <div class="sidebar-brand">
        <a href="./index.php" class="brand-link border-0 d-flex align-items-center justify-content-center w-100">
            <img src="img/logo.png?v=99" alt="CajaYa" style="height: 28px; width: auto; filter: brightness(0.2);">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">MENÚ PRINCIPAL</li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">OPERACIONES</li>
                <li class="nav-item">
                    <a href="./leads.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-users-viewfinder"></i>
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
                        <i class="nav-icon fa-solid fa-key"></i>
                        <p>Licencias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./catalogo.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'catalogo.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-box-archive"></i>
                        <p>Catálogo Maestro</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./ayuda.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-circle-question"></i>
                        <p>Centro de Ayuda</p>
                    </a>
                </li>

                <li class="nav-header">SISTEMA</li>
                <li class="nav-item">
                    <a href="./users.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-user-shield"></i>
                        <p>Accesos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./settings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>Configuración</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-3 mt-auto border-top text-center bg-light">
        <div class="x-small fw-bold text-muted">CajaYa | v2.6.0-AZURE</div>
    </div>
</aside>
