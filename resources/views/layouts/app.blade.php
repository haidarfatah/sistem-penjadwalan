<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjadwalan & Pengagajian</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/storage/icon/logo.png') }}" type="image/png">

    <!-- Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        /* ====      NAVBAR ========= */
        /* General Body and Container Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: black;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(45deg, #9ac5e5, #4fb19d);
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #88f4ff;
        }

        /* Navbar Menu Items */
        .nav-item {
            position: relative;
        }

        .nav-item a {
            color: white;
            font-size: 16px;
            padding: 10px 15px;
            margin: 0 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .nav-item a:hover {
            background-color: #edce7a;
            transform: translateY(-5px);
            border-radius: 5px;
            color: black
        }

        /* Icon Hover Effect */
        .nav-item a i {
            margin-right: 8px;
            transition: transform 0.3s;
        }

        .nav-item a:hover i {
            transform: scale(1.1);
        }

        /* Hiding Text by Default */
        .nav-item a span {
            display: none;
            position: absolute;
            bottom: -25px;
            font-size: 12px;
            background-color: #625ad8;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
            opacity: 0;
            transition: opacity 0.3s ease, bottom 0.3s ease;
        }

        /* Show Text When Hovering */
        .nav-item a:hover span {
            display: block;
            opacity: 1;
            bottom: -35px;
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            background-color: #c98c9a;
            border-radius: 5px;
        }

        .dropdown-item {
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #e5c6c3;
            color: #fff;
        }

        /* Search Button */
        .search-btn {
            background-color: #4fb19d;
            border: none;
            border-radius: 30px;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #edce7a;
        }

        .search-btn i {
            color: white;
        }

        /* Responsive Navbar */
        @media (max-width: 768px) {
            .navbar {
                padding: 10px 20px;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .nav-item a {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <!-- Brand and Welcome Text -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-leaf me-2"></i> Sistem Penjadwalan
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

                <!-- Navbar Menu -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i><span>Dashboard</span>
                        </a>
                    </li>

                    @if (Auth::user()->role == 'admin')
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i><span> Pengguna</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('karyawan.index') }}">
                                <i class="fas fa-user-tie"></i><span> Karyawan</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-calendar-alt"></i><span> Jadwal</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('jadwalkerja.belum') }}"><i
                                            class="fas fa-calendar-day"></i> Belum Memiliki Jadwal</a></li>
                                <li><a class="dropdown-item" href="{{ route('jadwalkerja.sudah') }}"><i
                                            class="fas fa-calendar-check"></i> Sudah Memiliki Jadwal</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('absensi.index') }}">
                                <i class="fas fa-check-circle"></i><span>Absensi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('penggajian.index') }}">
                                <i class="fas fa-wallet"></i><span>Penggajian</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('karyawan.absensi.index') }}">
                                <i class="fas fa-check-circle"></i><span>Absensi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('penggajian.index') }}">
                                <i class="fas fa-wallet"></i><span>Penggajian</span>
                            </a>
                        </li>
                    @endif

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifikasi.index') }}">
                            <i class="fas fa-bell"></i><span>Notifikasi</span>
                        </a>
                    </li> --}}

                    <!-- Profil & Logout -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i><span> User</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-circle me-2"></i> Profil: {{ Auth::user()->nama }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Form Logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </ul>

                <!-- Search Bar -->
                <form class="d-flex" action="" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Cari..."
                        aria-label="Search">
                    <button class="btn search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
