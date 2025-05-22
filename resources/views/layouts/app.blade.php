<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Bootstrap 5 & Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        #sidebar {
            height: 100vh;
            background-color: #343a40;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }

        #sidebar.collapsed {
            width: 70px;
        }

        #sidebar a {
            color: #fff;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            white-space: nowrap;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        #sidebar a i {
            margin-right: 10px;
        }

        #main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        #main-content.collapsed {
            margin-left: 70px;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-outline-light me-2" id="toggleSidebar"><i class="bi bi-list"></i></button>
            <a class="navbar-brand" href="#">ThriftStore</a>
            <div class="d-flex ms-auto">
                <span class="navbar-text me-3">Hi, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Sidebar --}}
    <div id="sidebar">
        @php $role = Auth::user()->role; @endphp

        @if ($role === 'admin')
            <a href="#"><i class="bi bi-speedometer2"></i><span class="link-text">Dashboard Admin</span></a>
            <a href="#"><i class="bi bi-people"></i><span class="link-text">Kelola Pengguna</span></a>
            <a href="#"><i class="bi bi-bar-chart-line"></i><span class="link-text">Laporan</span></a>
        @elseif ($role === 'owner')
            <a href="#"><i class="bi bi-box-seam"></i><span class="link-text">Produk Saya</span></a>
            <a href="#"><i class="bi bi-cart-check"></i><span class="link-text">Pesanan</span></a>
        @elseif ($role === 'pelanggan')
            <a href="#"><i class="bi bi-bag"></i><span class="link-text">Belanja</span></a>
            <a href="#"><i class="bi bi-truck"></i><span class="link-text">Pesanan Saya</span></a>
            <a href="#"><i class="bi bi-person"></i><span class="link-text">Akun</span></a>
        @endif
    </div>

    {{-- Main Content --}}
    <div id="main-content">
        <h3 class="mb-4">@yield('title')</h3>
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
