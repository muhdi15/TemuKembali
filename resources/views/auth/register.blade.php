<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - TemuKembali</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0061ff, #60efff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            padding: 40px 50px;
            max-width: 500px;
            width: 100%;
        }
        .btn-custom {
            background-color: #0061ff;
            color: white;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background-color: #004bd6;
            transform: translateY(-1px);
        }
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #0061ff;
            text-align: center;
            margin-bottom: 25px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="logo">
            🧭 TemuKembali
        </div>

        <h4 class="text-center mb-4">Buat Akun Baru</h4>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
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

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control form-control-lg" placeholder="Masukkan nama lengkap" required value="{{ old('nama') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="contoh@mail.com" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username unik Anda" required value="{{ old('username') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" placeholder="Ulangi kata sandi" required>
            </div>

            <button type="submit" class="btn btn-custom w-100 btn-lg">Daftar Sekarang</button>

            <p class="text-center mt-3 mb-0 text-muted">
                Sudah punya akun? <a href="/login" class="text-decoration-none fw-semibold">Masuk di sini</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
