<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedBase</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: bold;
            color: #0041C2;
            font-size: 1.8rem;
            letter-spacing: 0.5px;
        }
        .navbar-nav {
            margin: 0 auto;
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-item {
            position: relative;
        }
        .nav-link {
            color: #333 !important;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #0041C2 !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #0041C2;
            transition: all 0.3s;
        }
        .nav-link:hover::after {
            width: 100%;
            left: 0;
        }
        .navbar-nav .btn-link {
            background: none;
            border: none;
            font-weight: 500;
            font-size: 1.1rem;
        }
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        .auth-buttons .nav-link {
            padding: 0.5rem 1.5rem !important;
            border-radius: 5px;
        }
        .auth-buttons .nav-link:last-child {
            background: #0041C2;
            color: white !important;
        }
        .auth-buttons .nav-link:last-child:hover {
            background: #003399;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                BCH LinkedBase
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ruangan') ? 'active' : '' }}" href="{{ route('ruangan.index') }}">Ruangan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Pengajuan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('peminjaman.ruangan.create') }}">
                                <i class="fas fa-door-open me-2"></i>Peminjaman Ruangan</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('kerjasama.event.index') }}">
                                <i class="fas fa-handshake me-2"></i>Kerja Sama Event</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('kunjungan.visit.create') }}">
                                <i class="fas fa-building me-2"></i>Kunjungan Visit</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('mediapartner.create') }}">
                                <i class="fas fa-newspaper me-2"></i>Media Partner</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('pendaftaran.event.index') }}">
                                <i class="fas fa-newspaper me-2"></i>Pendaftaran Event</a>
                            </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('riwayat*') ? 'active' : '' }}" href="{{ route('riwayat.index') }}">
                            <i class="fas fa-history me-1"></i>Riwayat
                        </a>
                    </li>
                </ul>
                <div class="user-section d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <span>{{ Auth::user()->name }}</span>
                              
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <style>
        /* Navbar Styling */
        .navbar {
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
    
        .navbar-brand {
            font-weight: 700;
            color: #0041C2 !important;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
    
        .nav-item {
            margin: 0 5px;
        }
    
        .nav-link {
            color: #1a1a1a !important;
            font-weight: 500;
            padding: 0.7rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
    
        .nav-link:hover, .nav-link.active {
            color: #0041C2 !important;
            background-color: rgba(0, 65, 194, 0.1);
        }
    
        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 220px;
            animation: dropdownFade 0.2s ease;
        }
    
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    
        .dropdown-item {
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }
    
        .dropdown-item:hover {
            background-color: rgba(0, 65, 194, 0.1);
            color: #0041C2;
            transform: translateX(5px);
        }
    
        .dropdown-item i {
            color: #0041C2;
            width: 20px;
            font-size: 1rem;
        }
    
        /* User Section Styling */
        .user-section .dropdown-toggle {
            padding: 8px 16px;
            border-radius: 30px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    
        .user-section .dropdown-toggle:hover {
            background-color: #e9ecef;
        }
    
        .user-section .dropdown-toggle::after {
            margin-left: 8px;
        }
    
        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .navbar-nav {
                padding: 1rem 0;
            }
            
            .nav-item {
                margin: 5px 0;
            }
    
            .dropdown-menu {
                border: none;
                box-shadow: none;
                padding-left: 1rem;
            }
    
            .user-section {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #eee;
            }
        }
    </style>
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <!-- Add in the head section -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add before closing body tag -->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ is_array(session('success')) ? session('success')['title'] : 'Berhasil!' }}",
            text: "{{ is_array(session('success')) ? session('success')['message'] : session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif
</body>
</html>