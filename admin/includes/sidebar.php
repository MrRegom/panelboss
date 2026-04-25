<!-- Sidebar Centralizado -->
<aside class="app-sidebar shadow-sm" data-bs-theme="dark">
    <div class="sidebar-brand"> 
        <a href="./index.php" class="brand-link border-0 py-3"> 
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 35px; width: auto; margin-right: 10px;">
            <span class="brand-text fw-bold" style="font-size: 1.2rem; letter-spacing: -0.5px;">Panel<span class="text-primary">Boss</span></span> 
        </a> 
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-3">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                <li class="nav-item mb-2"> 
                    <a href="./index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-house"></i> <p>Dashboard</p> 
                    </a> 
                </li>
                <li class="nav-header small text-muted px-4 mt-3">OPERACIONES</li>
                <li class="nav-item mb-2"> 
                    <a href="./licenses.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-key"></i> <p>Licencias</p> 
                    </a> 
                </li>
                <li class="nav-item mb-2"> 
                    <a href="./companies.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'companies.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-building"></i> <p>Empresas</p> 
                    </a> 
                </li>
                <li class="nav-item mb-2"> 
                    <a href="./leads.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'leads.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-user-tag"></i> <p>Prospectos</p> 
                    </a> 
                </li>
                <li class="nav-header small text-muted px-4 mt-3">SISTEMA</li>
                <li class="nav-item mb-2"> 
                    <a href="./users.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-users-gear"></i> <p>Usuarios</p> 
                    </a> 
                </li>
                <li class="nav-item mb-2"> 
                    <a href="./settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>"> 
                        <i class="nav-icon fa-solid fa-gears"></i> <p>Configuración</p> 
                    </a> 
                </li>
            </ul>
        </nav>
    </div>
</aside>
