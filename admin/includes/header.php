<?php
// admin/includes/header.php - Header unificado con info de usuario (V111)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userName = $_SESSION['user_name'] ?? 'Administrador';
$userInitial = strtoupper(substr($userName, 0, 1));
?>
<nav class="app-header navbar navbar-expand">
    <div class="container-fluid px-3">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item"> 
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> 
                    <i class="fa-solid fa-bars-staggered"></i> 
                </a> 
            </li>
            <li class="nav-item ms-2 d-none d-md-block">
                <span class="text-muted small fw-medium">PANEL DE CONTROL CAJAYA ENTERPRISE</span>
            </li>
        </ul>
        
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <div class="user-profile-nav dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="user-profile-name d-none d-sm-inline"><?= htmlspecialchars($userName) ?></span>
                    <div class="user-avatar-circle">
                        <?= $userInitial ?>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 rounded-3">
                    <div class="px-4 py-3 border-bottom bg-light rounded-top-3">
                        <span class="d-block small fw-bold text-dark"><?= htmlspecialchars($userName) ?></span>
                        <span class="d-block x-small text-muted"><?= $_SESSION['user_role'] ?? 'Staff' ?></span>
                    </div>
                    <a href="profile.php" class="dropdown-item py-2 small">
                        <i class="fa-solid fa-user-gear me-2 text-primary"></i> Mi Perfil
                    </a>
                    <div class="dropdown-divider m-0"></div>
                    <a href="logout.php" class="dropdown-item py-2 small text-danger fw-bold">
                        <i class="fa-solid fa-power-off me-2"></i> Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
