<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sri Maharani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel CSS untuk kemudahan kustomisasi */
        :root {
            --sidebar-width: 280px; /* Lebar sidebar */
            --sidebar-bg-color: #2c3e50; /* Warna gelap untuk sidebar (biru keabu-abuan) */
            --sidebar-link-color: #ecf0f1; /* Warna teks link sidebar */
            --sidebar-link-hover-bg: #34495e; /* Warna hover link sidebar */
            --sidebar-active-bg: #1abc9c; /* Warna link aktif (hijau toska) */
            --sidebar-active-color: #ffffff; /* Warna teks link aktif */

            --topbar-height: 60px; /* Tinggi topbar */
            --topbar-bg-color: #ffffff;
            --topbar-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);

            --main-bg-color: #f4f7f6; /* Warna latar belakang konten utama */
            --card-bg-color: #ffffff;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --border-radius-base: 0.75rem;

            --primary-color: rgb(253, 201, 13); /* Warna kuning untuk elemen utama/tombol */
            --primary-hover-color: rgb(220, 175, 0);
            --text-dark: #343a40;
            --text-light: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--main-bg-color);
            margin: 0;
            padding: 0;
            display: flex; /* Menggunakan flexbox untuk layout utama */
            min-height: 100vh;
            overflow-x: hidden; /* Mencegah overflow horizontal */
        }

        /* --- Sidebar Styles --- */
        .sidebar-wrapper {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg-color);
            color: var(--sidebar-link-color);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1050; /* Di atas konten utama */
            overflow-y: auto;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Bayangan samping */
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--sidebar-active-color) !important;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex-grow: 1; /* Memastikan navigasi mengambil ruang yang tersedia */
            padding-top: 1rem;
        }
        .sidebar-nav .nav-item {
            margin-bottom: 0.25rem;
        }
        .sidebar-nav .nav-link {
            color: var(--sidebar-link-color);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            margin: 0 0.75rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-active-color);
        }
        .sidebar-nav .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .sidebar-nav .nav-link.active i {
            color: var(--sidebar-active-color);
        }

        /* --- Main Content & Top Bar --- */
        .main-container {
            flex-grow: 1; /* Konten utama akan mengambil sisa ruang */
            margin-left: var(--sidebar-width); /* Bergeser ke kanan sebesar lebar sidebar */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Agar footer selalu di bawah */
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            height: var(--topbar-height);
            background-color: var(--topbar-bg-color);
            box-shadow: var(--topbar-shadow);
            display: flex;
            justify-content: flex-end; /* Pindahkan item ke kanan */
            align-items: center;
            padding: 0 1.5rem;
            position: sticky; /* Agar tetap di atas saat scroll */
            top: 0;
            z-index: 1000; /* Di atas konten tapi di bawah sidebar jika mobile */
        }

        .top-bar .nav-item .nav-link {
            color: var(--text-dark);
            font-size: 1.1rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
        }
        .top-bar .nav-item .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* User Dropdown in Top Bar */
        .user-dropdown .user-avatar {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            transition: border-color 0.2s ease;
        }
        .user-dropdown:hover .user-avatar {
            border-color: var(--primary-hover-color);
        }
        .user-dropdown .user-name {
            font-weight: 500;
            color: var(--text-dark);
            margin-left: 0.5rem;
            margin-right: 0.25rem;
        }
        .user-dropdown .dropdown-toggle::after {
            font-family: "Font Awesome 5 Free"; /* Pastikan Font Awesome dikenali */
            font-weight: 900; /* Untuk ikon solid */
            content: "\f107"; /* Ikon chevron-down */
            border: none;
            vertical-align: middle;
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
        }
        .user-dropdown .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        .user-dropdown .dropdown-menu {
            border-radius: var(--border-radius-base);
            box-shadow: var(--card-shadow);
            border: none;
            margin-top: 0.75rem;
        }
        .user-dropdown .dropdown-item {
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            display: flex;
            align-items: center;
        }
        .user-dropdown .dropdown-item:hover {
            background-color: rgba(0, 0, 0, 0.03);
            color: var(--primary-color);
        }
        .user-dropdown .dropdown-item .fas {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
            color: var(--text-light); /* Warna ikon default */
        }
        .user-dropdown .dropdown-item:hover .fas {
            color: var(--primary-color); /* Warna ikon saat hover */
        }

        /* Notifikasi dan Keranjang di Top Bar */
        .top-bar .navbar-nav .nav-link {
            position: relative;
        }
        .top-bar .animated-badge {
            animation: pulse 1.5s infinite;
            font-size: 0.7em;
            padding: 0.4em 0.6em;
            border: 1px solid rgba(255,255,255,0.2);
            background-color: #dc3545; /* Merah untuk notifikasi */
            color: white;
        }
        .top-bar .animated-badge.bg-success {
            background-color: #28a745; /* Hijau untuk keranjang */
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Content Area */
        .content-area {
            flex-grow: 1; /* Konten area mengisi sisa ruang vertikal */
            padding: 1.5rem;
            background-color: var(--main-bg-color);
        }
        .card {
            border-radius: var(--border-radius-base);
            box-shadow: var(--card-shadow);
            border: none;
        }
        .card-header {
            background-color: var(--card-bg-color);
            border-bottom: 1px solid #eee;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            border-top-left-radius: var(--border-radius-base);
            border-top-right-radius: var(--border-radius-base);
        }

        /* Auth Buttons (Login/Register) */
        .auth-buttons .btn {
            border-radius: 2rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .auth-buttons .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        .auth-buttons .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .auth-buttons .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-dark); /* Teks gelap di tombol kuning */
        }
        .auth-buttons .btn-primary:hover {
            background-color: var(--primary-hover-color);
            border-color: var(--primary-hover-color);
            transform: translateY(-1px);
        }

        /* Offcanvas / Toggle for Mobile Sidebar */
        .offcanvas-sidebar {
            background-color: var(--sidebar-bg-color);
            color: var(--sidebar-link-color);
            width: var(--sidebar-width);
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }
        .offcanvas-sidebar.show {
            transform: translateX(0%);
        }
        .offcanvas-backdrop {
            z-index: 1045; /* Di bawah sidebar tapi di atas konten */
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 767.98px) {
            .sidebar-wrapper {
                transform: translateX(-100%); /* Sembunyikan sidebar secara default */
                box-shadow: none; /* Hilangkan bayangan saat tersembunyi */
            }
            .sidebar-wrapper.show { /* Kelas 'show' ditambahkan oleh Bootstrap Offcanvas */
                transform: translateX(0%);
            }
            .main-container {
                margin-left: 0; /* Konten utama tidak bergeser */
            }
            .top-bar .navbar-brand-mobile {
                display: block !important; /* Tampilkan brand di mobile top bar */
            }
            .top-bar .d-md-flex {
                display: none !important; /* Sembunyikan ikon di topbar jika mobile, karena sudah ada di sidebar */
            }
            /* Tombol toggle sidebar hanya muncul di mobile */
            .sidebar-toggler-btn {
                display: block !important;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-wrapper" id="sidebarMenu">
        <div class="sidebar-header">
            <a class="navbar-brand" href="#">Sri Maharani</a>
        </div>
        <nav class="sidebar-nav">
            @auth
                <ul class="nav flex-column">
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ url('/admin/categories') }}">
                                <i class="fas fa-th-list"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('products') ? 'active' : '' }}" href="{{ url('/products') }}">
                                <i class="fas fa-box-open"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ url('/admin/orders') }}">
                                <i class="fas fa-receipt"></i> Pesanan
                            </a>
                        </li>
                        @elseif(Auth::user()->role == 'owner')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('owner.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('owner.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('products') ? 'active' : '' }}" href="{{ url('/products') }}">
                                <i class="fas fa-box-open"></i> Produk Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('owner.orders.index') ? 'active' : '' }}" href="{{ route('owner.orders.index') }}">
                                <i class="fas fa-receipt"></i> Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('owner.statistics') ? 'active' : '' }}" href="{{ route('owner.statistics') }}">
                                <i class="fas fa-chart-line"></i> Statistik
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('owner.reviews.index') ? 'active' : '' }}" href="{{ route('owner.reviews.index') }}">
                                <i class="fas fa-star"></i> Ulasan
                            </a>
                        </li> -->
                        @elseif(Auth::user()->role == 'pelanggan')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('pelanggan.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('pelanggan.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <i class="fas fa-shopping-bag"></i> Belanja Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                <i class="fas fa-receipt"></i> Pesanan Saya
                            </a>
                        </li>
                        @endif
                </ul>
            @endauth
        </nav>
        @auth
        <div class="sidebar-footer p-3 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 rounded-pill">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
        @endauth
    </div>

    <div class="main-container">
        <header class="top-bar">
            <button class="btn btn-outline-secondary d-md-none sidebar-toggler-btn me-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand fw-bold d-md-none navbar-brand-mobile" href="#">Sri Maharani</a> {{-- Brand di mobile top bar --}}

            <div class="d-flex align-items-center">

                @auth
                    <div class="dropdown user-dropdown">
                        <!-- <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> -->
                            <!-- <img src="https://via.placeholder.com/40/cccccc/ffffff?text={{ substr(Auth::user()->name, 0, 1) }}" alt="Avatar" class="rounded-circle me-2 user-avatar"> -->
                            <span class="d-none d-lg-inline user-name">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                            @if(Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield"></i> Dashboard Admin</a></li>
                            @elseif(Auth::user()->role == 'owner')
                                <li><a class="dropdown-item" href="{{ route('owner.dashboard') }}"><i class="fas fa-store"></i> Dashboard Owner</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-user"></i> Dashboard Pelanggan</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-md-none d-block"> {{-- Logout di dropdown untuk mobile --}}
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex auth-buttons">
                        <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                    </div>
                @endauth
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebarMenu');
            var bsOffcanvas = new bootstrap.Offcanvas(sidebar, {
                backdrop: true, // Akan ada backdrop saat sidebar terbuka
                scroll: false // Body tidak scroll saat sidebar terbuka
            });

            // Handle toggling sidebar on small screens
            // Bootstrap 5 Offcanvas handles the 'show' class automatically
            // No custom JS needed for toggling unless you have specific interactions
        });
    </script>
    @stack('scripts')
</body>
</html>