<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - BCH LinkedBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @stack('styles')

   

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #E8EFFF;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #ffffff;
            min-height: 100vh;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            position: fixed;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #f0f2f5;
        }

        .navbar-brand {
            font-weight: bold;
            color: #0041C2;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }

        .logo-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section h2 {
            margin: 0;
            font-size: 20px;
            color: #1e293b;
        }

        nav {
            padding: 20px;
        }

        .menu-item {
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 5px 0;
        }

        .menu-item:hover {
            background: #F7F7F7;
        }

        .menu-item.active {
            background-color: #f0f4ff; /* warna latar biru muda */
            color: #0040C1;            /* teks biru */
            font-weight: 600;
        }

        .menu-group {
            margin: 5px 0;
        }

        .submenu {
            margin-left: 20px;
            display: none;
        }

        .menu-group.active .submenu {
            display: block;
        }

        .menu-item .fa-chevron-down {
            margin-left: auto;
            transition: transform 0.3s;
        }

        .menu-group.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        .logout-form {
            margin: 0;
        }

        .logout-item {
            border: none;
            cursor: pointer;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            color: #d10000;
            transition: all 0.3s;
            border-radius: 8px;
            font-size:16px;
        }

        .logout-item:hover {
            background: #fff5f5;
        }

        .main-content {
            
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background: #F7F7F7;
        }

        .top-navigation {
            background: white;
            padding: 16px 24px;
            margin: -20px -20px 24px -20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            z-index: 2;
        }

        .page-title h1 {
            margin: 0;
            font-size: 24px;
            color: #1e293b;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            padding: 8px;
        }

        .notification-icon i {
            font-size: 20px;
            color: #64748b;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #0041C2;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-image {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .admin-name {
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
        }

        .admin-role {
            font-size: 12px;
            color: #64748b;
        }

        /* Date Picker Styles */
        .flatpickr-calendar {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            font-family: 'Inter', sans-serif;
        }

        .flatpickr-months {
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
            padding: 8px;
        }

        .flatpickr-month {
            color: #1a1a1a;
        }

        .flatpickr-current-month {
            font-size: 16px;
            font-weight: 600;
        }

        .flatpickr-weekday {
            color: #666;
            font-weight: 600;
            font-size: 12px;
        }

        .flatpickr-day {
            border-radius: 6px;
            margin: 2px;
            color: #1a1a1a;
        }

        .flatpickr-day.selected {
            background: #0041C2;
            border-color: #0041C2;
        }

        .flatpickr-day.today {
            border-color: #0041C2;
        }

        .flatpickr-day:hover {
            background: #f0f2f5;
        }

        .flatpickr-day.selected:hover {
            background: #0041C2;
        }

        .flatpickr-prev-month, .flatpickr-next-month {
            color: #666 !important;
            padding: 4px;
        }

        .flatpickr-prev-month:hover, .flatpickr-next-month:hover {
            background: #e0e0e0;
            border-radius: 4px;
        }

    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo-section">
            <div class="navbar-brand">BCH LinkedBase</div>
        </div>
    </div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        
        <div class="menu-group {{ request()->is('admin/kelola/*') ? 'active' : '' }}">
            <div class="menu-item dropdown-trigger">
                <i class="fas fa-tasks"></i> <span>Kelola</span> <i class="fas fa-chevron-down"></i>
            </div>
            <div class="submenu">
                <a href="{{ route('admin.kelola.ruangan.index') }}" class="menu-item {{ request()->routeIs('admin.kelola.ruangan.*') ? 'active' : '' }}">Ruangan</a>
                <a href="{{ route('admin.kelola.event.index') }}" class="menu-item {{ request()->routeIs('admin.kelola.event.*') ? 'active' : '' }}">Event</a>
            </div>
        </div>

        <div class="menu-group {{ request()->is('admin/verifikasi/*') ? 'active' : '' }}">
            <div class="menu-item dropdown-trigger">
                <i class="fas fa-check-circle"></i> <span>Verifikasi Pengajuan</span> <i class="fas fa-chevron-down"></i>
            </div>
            <div class="submenu">
                <a href="{{ route('admin.verifikasi.peminjaman.index') }}" class="menu-item {{ request()->routeIs('admin.verifikasi.peminjaman.*') ? 'active' : '' }}">Peminjaman Ruangan</a>
                <a href="{{ route('admin.verifikasi.kunjungan.index') }}" class="menu-item {{ request()->routeIs('admin.verifikasi.kunjungan.*') ? 'active' : '' }}">Kunjungan Visit</a>
                <a href="{{ route('admin.verifikasi.mediapartner.index') }}" class="menu-item {{ request()->routeIs('admin.verifikasi.mediapartner.*') ? 'active' : '' }}">Media Partner</a>
                <a href="{{ route('admin.kerjasama.event.index') }}" class="menu-item {{ request()->routeIs('admin.kerjasama.event.*') ? 'active' : '' }}">Kerjasama Event</a>
            </div>
        </div>

        <a href="{{ route('admin.pendaftaran.event.index') }}" class="menu-item">
            <i class="fas fa-calendar-check"></i> Pendaftaran Event
        </a>

        <a href="{{ route('admin.list-user.index') }}" class="menu-item">
            <i class="fas fa-users"></i> List User
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </nav>
</div>

<div class="main-content">
    <div class="top-navigation">
        <div class="page-title">
            <h1>Dashboard</h1>
        </div>
        <div class="nav-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            @auth
                <div class="admin-profile">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile" class="profile-image">
                    <div class="profile-info">
                        <span class="admin-name">{{ Auth::user()->name }}</span>
                        <span class="admin-role">Admin</span>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endauth
        </div>
    </div>

    @yield('content')
</div>

<script>
   document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
    trigger.addEventListener('click', function () {
        const menuGroup = this.closest('.menu-group');
        document.querySelectorAll('.menu-group.active').forEach(group => {
            if (group !== menuGroup) group.classList.remove('active');
        });
        menuGroup.classList.toggle('active');
    });
});

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        });
</script>

@stack('scripts')
</body>
</html>
