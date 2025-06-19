<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm"> 
    <div class="container-fluid">
        {{-- Tombol Toggler untuk Sidebar (khusus mobile) --}}
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand me-auto fw-bold" href="#">Sri Maharani</a> 
        
        <div class="d-flex align-items-center"> 
            <ul class="navbar-nav flex-row me-3"> 
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bell"></i></a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
                </li>
            </ul>

            @auth
                <div class="dropdown"> 
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/30/cccccc/ffffff?text=U" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;"> 
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span> 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown"> 
                        @if(Auth::user()->role == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                        @elseif(Auth::user()->role == 'owner')
                            <li><a class="dropdown-item" href="{{ route('owner.dashboard') }}">Dashboard Owner</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('pelanggan.dashboard') }}">Dashboard Pelanggan</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="d-flex">
                    <a class="btn btn-outline-light me-2 rounded-pill" href="{{ route('login') }}">Login</a> 
                    <a class="btn btn-warning rounded-pill" href="{{ route('register') }}">Daftar</a> 
                </div>
            @endauth
        </div>
    </div>
</nav>