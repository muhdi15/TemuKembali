<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TemuKembali</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0061ff, #60efff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            padding: 40px 50px;
            max-width: 480px;
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

<div class="login-card">
    <div class="logo">🧭 TemuKembali</div>
    <h4 class="text-center mb-4">Masuk ke Akun Anda</h4>

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

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Username</label>
            <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Masukkan username Anda" value="{{ old('username') }}" required>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Masukkan kata sandi" required>
        </div>

        <button type="submit" class="btn btn-custom w-100 btn-lg">Masuk</button>

        <p class="text-center mt-3 mb-0 text-muted">
            Belum punya akun? <a href="/register" class="text-decoration-none fw-semibold">Daftar di sini</a>
        </p>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
