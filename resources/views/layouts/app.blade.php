<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Aplikasi Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Reset Password untuk SMK Telkom">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Custom CSS Variables */
            --primary-color: #b30000;
            --secondary-color: #800000;
            --accent-color: #f8f9fa;
            --text-light: #ffffff;
            --text-dark: #333333;
            --transition-speed: 0.3s;
            --card-border-radius: 15px;
            --btn-border-radius: 8px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--accent-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-dark);
            letter-spacing: 0.3px;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(150deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-lg);
            z-index: 1050;
            border-radius: 0 20px 20px 0;
            width: 270px;
            min-width: 270px;
            max-width: 90vw;
        }

        .sidebar-wrapper {
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: var(--btn-border-radius);
            margin-bottom: 8px;
            transition: all var(--transition-speed);
            font-weight: 500;
            padding: 10px 15px;
        }

        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            box-shadow: var(--shadow-sm);
            font-weight: 600;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--text-light);
            transform: translateX(3px);
            box-shadow: var(--shadow-sm);
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            box-shadow: var(--shadow-md);
            z-index: 1001;
            border-radius: 0 0 12px 12px;
            margin: 0 10px 10px 10px;
        }

        .navbar-brand {
            color: var(--text-light) !important;
            font-weight: 600;
        }

        .navbar .nav-link {
            color: var(--text-light) !important;
        }

        .navbar .fa-bell {
            font-size: 1.25rem;
        }

        /* Card and UI Elements */
        .card {
            border-radius: var(--card-border-radius);
            border: none;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-speed);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .btn {
            border-radius: var(--btn-border-radius);
            transition: all var(--transition-speed);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border-radius: var(--btn-border-radius);
            border: none;
            box-shadow: var(--shadow-md);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: var(--btn-border-radius);
            padding: 0.5rem 1rem;
            transition: all var(--transition-speed);
        }

        .dropdown-item:hover {
            background-color: rgba(179, 0, 0, 0.05);
        }

        /* Badge Styles */
        .badge {
            padding: 0.4em 0.6em;
            font-weight: 500;
            border-radius: 6px;
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 1rem 0;
            margin-top: auto;
            border-radius: 12px 12px 0 0;
            margin: 10px 10px 0 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                height: auto;
                position: relative;
            }

            .sidebar {
                width: 80vw;
                max-width: 320px;
                height: 100vh;
                border-radius: 0 20px 20px 0;
                position: fixed;
                top: 0;
                left: -100vw;
                z-index: 2000;
                transition: left 0.35s cubic-bezier(0.4,0,0.2,1);
                box-shadow: var(--shadow-lg);
            }
            .sidebar.show {
                left: 0;
            }
            .sidebar-backdrop {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.25);
                z-index: 1999;
                opacity: 1;
                transition: opacity 0.3s;
            }
            .sidebar-backdrop.hide {
                opacity: 0;
                pointer-events: none;
            }
            .content-wrapper {
                margin-left: 0;
            }
            .navbar {
                margin: 0 0 10px 0;
                border-radius: 0 0 12px 12px;
            }
            .footer {
                margin: 10px 0 0 0;
                border-radius: 12px 12px 0 0;
            }
        }

        /* Table Styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-responsive {
            border-radius: var(--card-border-radius);
            overflow: hidden;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: var(--btn-border-radius);
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            transition: all var(--transition-speed);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(179, 0, 0, 0.3);
            box-shadow: 0 0 0 0.25rem rgba(179, 0, 0, 0.1);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="d-flex flex-column min-vh-100">

    <div id="sidebar-backdrop" class="sidebar-backdrop hide" onclick="toggleSidebar(false)"></div>
    <div class="d-flex flex-column flex-lg-row">
        {{-- Sidebar --}}
        <div class="sidebar">
            <div class="sidebar-wrapper p-3">
                <div class="d-flex align-items-center mb-4 px-2">
                    <div
                        class="icon-shape icon-sm rounded-circle bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shield-alt text-primary"></i>
                    </div>
                    <h5 class="text-white mb-0 fw-bold">Reset System</h5>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 mb-1 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>

                <div class="mb-2 mt-3 text-uppercase small fw-bold opacity-75">Manajemen Data</div>
                <a href="{{ route('siswa.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Siswa
                </a>
                <a href="{{ route('jurusan.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                    <i class="fas fa-code-branch me-2"></i> Jurusan
                </a>
                <a href="{{ route('kelas.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard me-2"></i> Kelas
                </a>

                <hr class="border-light opacity-25 my-3">

                <div class="mb-2 text-uppercase small fw-bold opacity-75">Pengajuan Reset</div>
                <a href="{{ route('admin.pengajuan-google.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.pengajuan-google.*') ? 'active' : '' }}">
                    <i class="fab fa-google me-2"></i> Google
                </a>
                <a href="{{ route('pengajuan-mylms.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('pengajuan-mylms.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap me-2"></i> MyLMS
                </a>
                <a href="{{ route('pengajuan-igracias.index') }}"
                    class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('pengajuan-igracias.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate me-2"></i> iGracias
                </a>
            </div>
        </div>


        {{-- Main Content --}}
        <div class="flex-grow-1 content-wrapper">
            {{-- Navbar --}}
            <nav class="navbar navbar-expand-lg shadow-sm px-4">
                <div class="container-fluid">
                    <button class="btn btn-icon d-lg-none me-2" type="button" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-white"></i>
                    </button>

                    <ul class="navbar-nav ms-auto align-items-center">
                        {{-- Notifikasi --}}
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notifDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell fa-lg"></i>
                                @if (isset($totalNotif) && $totalNotif > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                        {{ $totalNotif }}
                                    </span>
                                @endif
                            </a>

                            {{-- Dropdown Notifikasi --}}
                            <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 320px;"
                                aria-labelledby="notifDropdown">
                                <li class="dropdown-header fw-bold">Pengajuan Baru</li>

                                {{-- Google --}}
                                @foreach (\App\Models\PengajuanResetGoogle::with('siswa')->where('status_pengajuan', true)->latest()->limit(2)->get() as $item)
                                    <li>
                                        <a href="{{ route('admin.pengajuan-google.index') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <img src="https://i.pravatar.cc/40?u={{ $item->siswa_id }}"
                                                class="rounded-circle me-2" width="40" height="40">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $item->siswa->nama ?? 'Siswa' }}</div>
                                                <small class="text-muted">Mengajukan reset akun Google</small><br>
                                                <small class="text-muted"><i
                                                        class="fas fa-clock me-1"></i>{{ $item->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                {{-- MyLMS --}}
                                @foreach (\App\Models\PengajuanResetMylms::with('siswa')->where('status_pengajuan', true)->latest()->limit(2)->get() as $item)
                                    <li>
                                        <a href="{{ route('pengajuan-mylms.index') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <img src="https://i.pravatar.cc/40?u={{ $item->siswa_id }}"
                                                class="rounded-circle me-2" width="40" height="40">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $item->siswa->nama ?? 'Siswa' }}</div>
                                                <small class="text-muted">Mengajukan reset akun MyLMS</small><br>
                                                <small class="text-muted"><i
                                                        class="fas fa-clock me-1"></i>{{ $item->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                {{-- iGracias --}}
                                @foreach (\App\Models\PengajuanResetIgracias::with('siswa')->where('status_pengajuan', true)->latest()->limit(2)->get() as $item)
                                    <li>
                                        <a href="{{ route('pengajuan-igracias.index') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <img src="https://i.pravatar.cc/40?u={{ $item->siswa_id }}"
                                                class="rounded-circle me-2" width="40" height="40">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $item->siswa->nama ?? 'Siswa' }}</div>
                                                <small class="text-muted">Mengajukan reset akun iGracias</small><br>
                                                <small class="text-muted"><i
                                                        class="fas fa-clock me-1"></i>{{ $item->created_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-center text-primary"
                                        href="{{ route('admin.dashboard') }}">Lihat Semua Pengajuan</a></li>
                            </ul>
                        </li>

                        {{-- Dropdown Profile --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'User' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button class="dropdown-item"><i
                                                class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Main content --}}
            <main class="p-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>

            {{-- Footer --}}
            <footer class="footer py-3 mt-auto">
                <div class="container-fluid text-center">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-0">&copy; {{ date('Y') }} Aplikasi Reset Password - SMK Telkom. All
                                rights reserved.</p>
                            <small>Developed with <i class="fas fa-heart text-danger"></i> by IT Team</small>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar mobile toggle
        function toggleSidebar(force) {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isOpen = sidebar.classList.contains('show');
            if (force === true || (!isOpen && force === undefined)) {
                sidebar.classList.add('show');
                backdrop.classList.remove('hide');
            } else {
                sidebar.classList.remove('show');
                backdrop.classList.add('hide');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const mediaQuery = window.matchMedia('(max-width: 992px)');
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            function handleScreenChange(e) {
                if (e.matches) {
                    sidebar.classList.remove('collapse');
                    sidebar.id = 'sidebarMenu';
                    sidebar.classList.remove('show');
                    backdrop.classList.add('hide');
                } else {
                    sidebar.classList.remove('collapse');
                    sidebar.removeAttribute('id');
                    sidebar.classList.remove('show');
                    backdrop.classList.add('hide');
                }
            }
            mediaQuery.addEventListener('change', handleScreenChange);
            handleScreenChange(mediaQuery);
        });
    </script>
    @stack('scripts')

</body>

</html>
