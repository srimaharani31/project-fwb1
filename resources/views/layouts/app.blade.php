<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Saya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome untuk ikon (Opsional, tapi bagus untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light background */
        }
        .navbar {
            background-color:rgb(253, 201, 13); /* Primary blue */
        }
        .navbar .nav-link, .navbar .navbar-brand {
            color: #ffffff !important;
        }
        .navbar .nav-link:hover {
            color: #e2e6ea !important;
        }
        .card {
            border-radius: 0.75rem; /* Rounded corners for cards */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
        }
        footer {
            background-color: #343a40; /* Dark footer */
            color: white;
            padding: 1.5rem 0;
            margin-top: 3rem;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            padding-top: 1rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Fixed sidebar width */
            overflow-y: auto;
            transition: all 0.3s;
        }
        .sidebar a {
            color: #adb5bd;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            border-radius: 0.5rem;
            margin: 0 10px 5px 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: white;
        }
        .main-content {
            margin-left: 250px; /* Adjust content margin to match sidebar width */
            padding: 20px;
            transition: all 0.3s;
        }

        /* Responsive adjustments for sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.active {
                width: 250px;
            }
            .main-content.active {
                margin-left: 250px;
            }
        }
        
    </style>
</head>
<body>

    @include('partials._navbar')

    <div class="container-fluid">
        <div class="row">
            @auth
                @if(Auth::user()->role == 'admin')
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ url('/users') }}">
                                        <i class="fas fa-users me-2"></i> Pengguna
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ url('/admin/categories') }}">
                                        <i class="fas fa-tags me-2"></i> Kategori
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('products') ? 'active' : '' }}" href="{{ url('/products') }}">
                                        <i class="fas fa-box-open me-2"></i> Produk
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ url('/admin/orders') }}">
                                        <i class="fas fa-receipt me-2"></i> Pesanan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @elseif(Auth::user()->role == 'owner')
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('owner.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('owner.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('products') ? 'active' : '' }}" href="{{ url('/products') }}">
                                        <i class="fas fa-box-open me-2"></i> Produk Saya
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('owner.orders.index') ? 'active' : '' }}" href="{{ route('owner.orders.index') }}">
                                        <i class="fas fa-receipt me-2"></i> Pesanan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('owner.statistics') ? 'active' : '' }}" href="{{ route('owner.statistics') }}">
                                        <i class="fas fa-chart-line me-2"></i> Statistik
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('owner.reviews.index') ? 'active' : '' }}" href="{{ route('owner.reviews.index') }}">
                                        <!-- <i class="fas fa-star me-2"></i> Ulasan -->
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @elseif(Auth::user()->role == 'pelanggan')
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('pelanggan.dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('pelanggan.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                        <i class="fas fa-store me-2"></i> Belanja Produk
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                        <i class="fas fa-receipt me-2"></i> Pesanan Saya
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @endif
            @endauth

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @yield('content')
            </main>
        </div>
    </div>

   

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Script for sidebar toggle on small screens -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const sidebar = document.querySelector('#sidebarMenu');
            const mainContent = document.querySelector('.main-content');

            navbarToggler.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('active');
            });

            // Close sidebar when clicking outside on small screens
            mainContent.addEventListener('click', function() {
                if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('active');
                }
            });
        });
    </script>
    @stack('scripts')

     
</body>
</html>
