<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin ESP - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a237e, #283593);
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            padding-top: 20px;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 10px;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-top {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            margin-left: 250px;
        }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .stat-card { border-left: 4px solid; }
        .logo-text { font-size: 1.3rem; font-weight: bold; padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.2); margin-bottom: 20px; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-text">
            <i class="fas fa-shield-alt me-2"></i> ESP Admin
        </div>
        <nav class="nav flex-column">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}">
        <i class="fas fa-users me-2"></i> Utilisateurs
    </a>
    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
        <i class="fas fa-user-tag me-2"></i> Rôles
    </a>
    <a href="{{ route('admin.rapports.index') }}" class="nav-link {{ request()->routeIs('admin.rapports.*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-2"></i> Rapports
    </a>
    <a href="{{ route('admin.sauvegardes.index') }}" class="nav-link {{ request()->routeIs('admin.sauvegardes.*') ? 'active' : '' }}">
        <i class="fas fa-database me-2"></i> Sauvegardes
    </a>
    <a href="{{ route('admin.surveillance.index') }}" class="nav-link {{ request()->routeIs('admin.surveillance.*') ? 'active' : '' }}">
        <i class="fas fa-server me-2"></i> Surveillance
    </a>
</nav>
    </div>

    <!-- Top navbar -->
    <div class="navbar-top d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@yield('title')</h5>
        <div>
            <i class="fas fa-user-circle me-2"></i> Administrateur Système
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>