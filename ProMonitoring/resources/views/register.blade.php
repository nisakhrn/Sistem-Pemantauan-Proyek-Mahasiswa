<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ProMonitor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <!-- Pastikan Font Awesome sudah ditambahkan -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Kembali ke halaman landing menggunakan panah -->
    <div class="back-to-landing">
        <a href="{{ route('landing') }}" class="back-arrow">
            <i class="fas fa-arrow-left"></i> <!-- Ikon panah -->
        </a>
    </div>

    <div class="auth-container">
        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="auth-title">📝 Daftar</h2>
            <p class="auth-subtitle">Bergabunglah dengan komunitas ProMonitor dan mulai perjalanan Anda!</p>
            
            <div class="form-group">
                <label for="name" class="form-label">👤 Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">📧 Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">🔑 Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Buat password yang kuat" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">🔐 Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password Anda" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; margin-bottom: 1rem;">
                Daftar Sekarang
            </button>
            
            <div class="auth-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
    </div>
</body>
</html>
