<!-- Double Sidebar Layout -->
<aside class="app-sidebar shadow-sm d-flex" data-bs-theme="dark" style="width: 280px; transition: all 0.3s;">
    <!-- Primary Sidebar (Slim Icons) -->
    <div class="primary-sidebar d-flex flex-column align-items-center py-4" style="width: 70px; background: #070708; border-right: 1px solid rgba(255,255,255,0.05);">
        <a href="./index.php" class="mb-5">
            <img src="https://cajaya.cl/assets/logo.png" alt="CajaYa" style="height: 30px; width: auto; filter: drop-shadow(0 0 8px rgba(124, 58, 237, 0.4));">
        </a>
        
        <ul class="nav flex-column gap-4 text-center w-100">
            <li class="nav-item">
                <a href="./index.php" class="nav-link p-0 <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-white' : 'text-muted' ?>" title="Dashboard">
                    <i class="fa-solid fa-house fs-5"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="./leads.php" class="nav-link p-0 <?= in_array(basename($_SERVER['PHP_SELF']), ['leads.php', 'companies.php']) ? 'text-white' : 'text-muted' ?>" title="CRM">
                    <i class="fa-solid fa-user-tag fs-5"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="./licenses.php" class="nav-link p-0 <?= basename($_SERVER['PHP_SELF']) == 'licenses.php' ? 'text-white' : 'text-muted' ?>" title="Licencias">
                    <i class="fa-solid fa-key fs-5"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="./settings.php" class="nav-link p-0 <?= in_array(basename($_SERVER['PHP_SELF']), ['settings.php', 'users.php']) ? 'text-white' : 'text-muted' ?>" title="Sistema">
                    <i class="fa-solid fa-gears fs-5"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="secondary-sidebar flex-grow-1 py-4 px-2" style="background: var(--bg-surface);">
        <h6 class="text-uppercase x-small fw-bold text-muted px-3 mb-4 letter-spacing-1" style="font-size: 0.65rem;">Navegación</h6>
        
        <nav class="nav flex-column px-2">
            <!-- Dynamic Submenu based on current section -->
            <?php 
            $current_file = basename($_SERVER['PHP_SELF']);
            if (in_array($current_file, ['index.php'])): ?>
                <a href="./index.php" class="nav-link sub-link <?= $current_file == 'index.php' ? 'active-sub' : '' ?>">
                    <i class="fa-solid fa-chart-pie me-2 small"></i> Resumen General
                </a>
            <?php elseif (in_array($current_file, ['leads.php', 'companies.php'])): ?>
                <a href="./leads.php" class="nav-link sub-link <?= $current_file == 'leads.php' ? 'active-sub' : '' ?>">
                    <i class="fa-solid fa-user-tag me-2 small"></i> Prospectos
                </a>
                <a href="./companies.php" class="nav-link sub-link <?= $current_file == 'companies.php' ? 'active-sub' : '' ?>">
                    <i class="fa-solid fa-building me-2 small"></i> Empresas
                </a>
            <?php elseif ($current_file == 'licenses.php'): ?>
                <a href="./licenses.php" class="nav-link sub-link active-sub">
                    <i class="fa-solid fa-list-check me-2 small"></i> Listado Licencias
                </a>
                <a href="#" class="nav-link sub-link text-muted x-small mt-2">
                    <i class="fa-solid fa-plus me-2"></i> Generar Masivo
                </a>
            <?php elseif (in_array($current_file, ['settings.php', 'users.php'])): ?>
                <a href="./users.php" class="nav-link sub-link <?= $current_file == 'users.php' ? 'active-sub' : '' ?>">
                    <i class="fa-solid fa-users-gear me-2 small"></i> Usuarios
                </a>
                <a href="./settings.php" class="nav-link sub-link <?= $current_file == 'settings.php' ? 'active-sub' : '' ?>">
                    <i class="fa-solid fa-gears me-2 small"></i> Ajustes Sistema
                </a>
            <?php endif; ?>
        </nav>

        <div class="mt-auto px-3">
            <div class="p-3 rounded-3" style="background: rgba(139, 92, 246, 0.03); border: 1px solid var(--border);">
                <p class="x-small text-muted mb-1" style="font-size: 0.6rem;">BUILD 2.4.0</p>
                <p class="small fw-bold text-white mb-0">CajaYa Pro</p>
            </div>
        </div>
    </div>
</aside>
