<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | TemuKembali')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            transition: all 0.3s;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #9b1b30, #c4455c);
            color: white;
            position: fixed;
            width: 250px;
            padding-top: 1.5rem;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar h4 {
            font-size: 1.3rem;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed h4 {
            opacity: 0;
            visibility: hidden;
        }

        .sidebar .nav-link {
            color: white;
            margin: 6px 0;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            white-space: nowrap;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* Content area */
        .content {
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .content.expanded {
            margin-left: 80px;
        }

        /* Navbar */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-bottom: 3px solid #f4d7da;
        }

        .logout-btn {
            background-color: #c4455c;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background-color: #9b1b30;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #9b1b30;
            cursor: pointer;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c4455c;
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-flex flex-column p-3">
        <h4 class="text-center mb-4"><i class="bi bi-gem"></i> TemuKembali</h4>
        <ul class="nav flex-column">
            <li><a href="{{ url('/admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
            <li><a href="{{ url('/admin/pengguna') }}" class="nav-link {{ Request::is('admin/pengguna*') ? 'active' : '' }}"><i class="bi bi-people"></i><span>Manajemen Pengguna</span></a></li>
            <li><a href="{{ url('/admin/laporan-hilang') }}" class="nav-link {{ Request::is('admin/laporan-hilang*') ? 'active' : '' }}"><i class="bi bi-exclamation-triangle"></i><span>Laporan Kehilangan</span></a></li>
            <li><a href="{{ url('/admin/laporan-temuan') }}" class="nav-link {{ Request::is('admin/laporan-temuan*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i><span>Laporan Temuan</span></a></li>
            <li><a href="{{ url('/admin/pencocokan') }}" class="nav-link {{ Request::is('admin/pencocokan*') ? 'active' : '' }}"><i class="bi bi-link-45deg"></i><span>Pencocokan Data</span></a></li>
            <li><a href="{{ url('/admin/notifikasi') }}" class="nav-link {{ Request::is('admin/notifikasi*') ? 'active' : '' }}"><i class="bi bi-bell"></i><span>Notifikasi</span></a></li>
            <li><a href="{{ url('/admin/laporan') }}" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i><span>Laporan & Statistik</span></a></li>
        </ul>
        <hr>
        <a href="{{ route('logout') }}" class="nav-link text-light"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- Content -->
    <div id="content" class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="toggle-btn" id="toggleSidebar"><i class="bi bi-list"></i></button>
                <span class="navbar-brand fw-semibold ms-2 text-maroon">@yield('page-title', 'Dashboard Admin')</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-semibold text-maroon">Halo, {{ Auth::user()->nama ?? 'Admin' }} 👋</span>
                    <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
