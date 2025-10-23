<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - TemuKembali</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      transition: all 0.3s;
    }

    /* Sidebar */
    .sidebar {
      height: 100vh;
      background: linear-gradient(180deg, #0061ff, #60efff);
      color: white;
      position: fixed;
      width: 250px;
      padding-top: 1.5rem;
      transition: all 0.3s ease;
      overflow-y: auto;
      z-index: 100;
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
      margin: 5px 0;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.3s;
      white-space: nowrap;
    }

    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 8px;
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

    .navbar {
      background-color: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .logout-btn {
      background-color: #dc3545;
      border: none;
      color: white;
      padding: 6px 12px;
      border-radius: 5px;
      transition: all 0.3s;
    }

    .logout-btn:hover {
      background-color: #bb2d3b;
    }

    .toggle-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #333;
      cursor: pointer;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar d-flex flex-column p-3">
    <h4 class="text-center mb-4"><i class="bi bi-compass"></i> TemuKembali</h4>
    <ul class="nav flex-column">
      <li><a href="#" class="nav-link active"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-people"></i><span>Manajemen Pengguna</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-exclamation-triangle"></i><span>Laporan Kehilangan</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-box-seam"></i><span>Laporan Temuan</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-link-45deg"></i><span>Pencocokan Data</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-bell"></i><span>Notifikasi Sistem</span></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-bar-chart"></i><span>Laporan & Statistik</span></a></li>
    </ul>
    <hr>
    <form method="POST" action="{{route('logout')}}">
            @csrf
            <button class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
  </div>

  <!-- Content -->
  <div id="content" class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
      <div class="container-fluid">
        <button class="toggle-btn" id="toggleSidebar"><i class="bi bi-list"></i></button>
        <span class="navbar-brand fw-semibold ms-2">Dashboard Admin</span>
        <div class="d-flex align-items-center">
          <span class="me-3 fw-semibold">Halo, {{Auth::user()->username}} 👋</span>
          <form method="POST" action="{{route('logout')}}">
            @csrf
            <button class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</button>
          </form>
        </div>
      </div>
    </nav>


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
</body>
</html>
