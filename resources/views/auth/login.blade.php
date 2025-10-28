<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TemuKembali</title>

    <!-- Bootstrap & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 10% 10%, #ffe6e6, #590010 90%);
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
        }

        /* Scrollbar */
        body::-webkit-scrollbar {
            width: 10px;
        }
        body::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 8px;
        }

        /* Background animasi */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: moveOrb 15s infinite ease-in-out alternate;
            z-index: 1;
        }

        .orb1 { width: 300px; height: 300px; background: #b91c1c; top: 10%; left: 10%; animation-delay: 0s; }
        .orb2 { width: 400px; height: 400px; background: #dc2626; bottom: 15%; right: 15%; animation-delay: 3s; }

        @keyframes moveOrb {
            0% { transform: translate(0,0); }
            100% { transform: translate(30px, -40px); }
        }

        /* Container */
        .page-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Card login */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 24px;
            padding: 45px 35px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.25);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo */
        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            margin-bottom: 25px;
            text-align: center;
        }

        .brand-logo img {
            width: 120px;
            height: auto;
            margin-bottom: 12px;
            filter: drop-shadow(0 0 15px rgba(255, 0, 64, 0.6));
            animation: float 4s ease-in-out infinite;
            transition: transform 0.4s ease, filter 0.4s ease;
        }

        .brand-logo img:hover {
            transform: scale(1.08);
            filter: drop-shadow(0 0 25px rgba(255, 100, 120, 0.8));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .brand-logo h3 {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Form */
        .form-label {
            color: #fff;
            font-weight: 500;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.85);
            border: none;
            border-radius: 12px;
            height: 48px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.3);
            transform: scale(1.02);
        }

        /* Tombol */
        .btn-maroon {
            background: linear-gradient(90deg, #b91c1c, #f87171);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-maroon:hover {
            background: linear-gradient(90deg, #9f1239, #ef4444);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(185, 28, 28, 0.4);
        }

        .alert {
            border-radius: 10px;
        }

        .text-muted a {
            color: #fca5a5;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }

        /* Responsif */
        @media (max-height: 700px) {
            .page-container {
                align-items: flex-start;
                padding-top: 60px;
            }
        }

        @media (max-width: 480px) {
            .glass-card {
                padding: 30px 25px;
                border-radius: 20px;
            }
            .brand-logo img {
                width: 90px;
            }
        }
    </style>
</head>

<body>
    <!-- Background animasi -->
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>

    <div class="page-container">
        <!-- Card -->
        <div class="glass-card">
            <div class="brand-logo">
                <!-- Logo yang sama seperti sebelumnya -->
                <img src="https://cdn-icons-png.flaticon.com/512/8915/8915931.png" alt="Logo TemuKembali">
                <h3>TemuKembali</h3>
                <p class="text-light text-opacity-80 text-sm">Sistem Pelaporan Barang Hilang & Temuan</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="bi bi-person-circle me-1"></i> Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control"
                        placeholder="Masukkan username Anda" value="{{ old('username') }}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i> Kata Sandi
                    </label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan kata sandi" required>
                </div>

                <button type="submit" class="btn btn-maroon w-100 py-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>

                <p class="text-center mt-4 text-light text-opacity-80">
                    Belum punya akun?
                    <a href="/register" class="fw-semibold">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
