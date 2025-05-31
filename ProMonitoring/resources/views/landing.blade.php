<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProMonitor - Sistem Pemantauan Proyek Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Floating background elements -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- Particle background -->
    <div class="particles" id="particles"></div>
    
    <!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('landing') }}" class="logo">
             🌊 ProMonitor
        </a>

        <ul class="nav-menu">
            <!-- Tautan Beranda -->
            <li><a href="#landing" class="nav-link active" id="nav-beranda" onclick="setActiveNav('nav-beranda')">Beranda</a></li>
            <!-- Tautan Fitur -->
            <li><a href="#fitur" class="nav-link" id="nav-fitur" onclick="setActiveNav('nav-fitur')">Fitur</a></li>
            <!-- Tautan Tentang -->
            <li><a href="#about" class="nav-link" id="nav-tentang" onclick="setActiveNav('nav-tentang')">Tentang</a></li>
        </ul>
        
        <div class="auth-buttons" id="authButtons">
            <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="btn">Daftar</a>
        </div>
    </div>
</nav>


    <!-- Landing Page -->
    <div id="landing" class="page active">
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title pulse">ProMonitor</h1>
                <p class="hero-subtitle">
                    Revolusioner dalam pemantauan proyek mahasiswa dengan teknologi terdepan.
                    Kelola, pantau, dan evaluasi semua proyek akademik dalam satu platform yang elegan.
                </p>
                <div>
                    <a href="{{ route('register') }}" class="btn" style="margin: 0.5rem; font-size: 1.1rem; padding: 15px 30px;">
                        🚀 Mulai Sekarang
                    </a>
                    <a href="#fitur" class="btn btn-outline" style="margin: 0.5rem; font-size: 1.1rem; padding: 15px 30px;">
                        📖 Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

        <!-- Fitur Utama -->
        <section class="features-section" id="fitur">
            <div class="container">
                <h2 class="section-title">Fitur Utama</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <span class="feature-icon">📊</span>
                        <h3 class="feature-title">Dashboard Interaktif</h3>
                        <p class="feature-description">
                            Visualisasi data proyek dengan grafik real-time yang memudahkan monitoring progress dan analisis performa.
                        </p>
                    </div>
                    <div class="feature-card">
                        <span class="feature-icon">🔄</span>
                        <h3 class="feature-title">Manajemen CRUD</h3>
                        <p class="feature-description">
                            Sistem Create, Read, Update, Delete yang lengkap untuk mengelola semua aspek proyek dengan mudah.
                        </p>
                    </div>
                    <div class="feature-card">
                        <span class="feature-icon">🔔</span>
                        <h3 class="feature-title">Notifikasi Smart</h3>
                        <p class="feature-description">
                            Sistem notifikasi cerdas yang memberikan pengingat deadline dan update progress secara otomatis.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang Proyek -->
        <section class="about-section" id="about">
            <div class="container">
                <h2 class="section-title">Tentang ProMonitor</h2>
                <div class="about-card" style="max-width: 800px; margin: 0 auto; text-align: center;">
                    <span class="feature-icon">🎓</span>
                    <h3 class="feature-title">Proyek Ini Dibuat Oleh</h3>
                    <p class="feature-description" style="font-size: 1.1rem; line-height: 1.8;">
                        ProMonitor adalah aplikasi yang dibuat untuk membantu mahasiswa dalam memantau dan mengelola proyek akademik mereka. Aplikasi ini dibuat oleh <strong>Khairun Nisa</strong>, mahasiswa dengan <strong>NPM 2308107010074</strong> dari kelas <strong>PBW B</strong>.
                    </p>
                    <img src="{{ asset('images/nisaa.jpg') }}" alt="Khairun Nisa" style="width: 150px; border-radius: 50%; margin-top: 15px;">
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
