ProMonitor – Aplikasi Pemantauan Proyek Mahasiswa

Khairun Nisa
2308107010074
Project PBW B

**Deskripsi Aplikasi**
ProMonitor adalah aplikasi manajemen proyek berbasis Laravel yang dirancang untuk membantu mahasiswa dalam memantau perkembangan proyek mereka. Aplikasi ini menyediakan antarmuka yang mudah digunakan untuk membuat, mengelola, dan mengevaluasi proyek secara efisien.
Fitur Utama:
1. Registrasi dan login pengguna
2. Pembuatan, pengeditan, dan penghapusan proyek
3. Pemantauan status proyek: Aktif, Progress, dan Selesai
4. Manajemen profil pengguna
5. Statistik ringkasan proyek di dashboard


**Penjelasan Code**

## Penjelasan Halaman Landing (`landing.blade.php`)

**Fungsi**
Halaman **landing** adalah halaman utama atau depan aplikasi sebelum pengguna login. Ini berfungsi sebagai pengenalan aplikasi dan tempat pengguna bisa memilih untuk **daftar** atau **masuk**.


### Struktur Utama Kode
1. **HTML Header & Meta**
```html
<head>
    ...
    <title>ProMonitor - Sistem Pemantauan Proyek Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
```
* Menyiapkan judul halaman.
* CSRF token untuk keamanan jika ada AJAX.
* Mengimpor CSS khusus landing page.


#### 2. **Navigasi (Navbar)**
```html
<nav class="navbar">
    ...
    <ul class="nav-menu">
        <li><a href="#landing" ...>Beranda</a></li>
        <li><a href="#fitur" ...>Fitur</a></li>
        <li><a href="#about" ...>Tentang</a></li>
    </ul>
    <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
        <a href="{{ route('register') }}" class="btn">Daftar</a>
    </div>
</nav>
```
* Link navigasi ke bagian-bagian halaman (scroll to section).
* Tombol **Masuk** dan **Daftar** yang diarahkan ke route `login` dan `register`.


#### 3. **Hero Section (Bagian utama)**
```html
<section class="hero-section">
    ...
    <h1 class="hero-title pulse">ProMonitor</h1>
    <p class="hero-subtitle">Revolusioner dalam pemantauan proyek mahasiswa...</p>
    <a href="{{ route('register') }}" class="btn">🚀 Mulai Sekarang</a>
    <a href="#fitur" class="btn btn-outline">📖 Pelajari Lebih Lanjut</a>
</section>
```
* Bagian sambutan dengan judul besar dan deskripsi.
* Tombol langsung daftar dan scroll ke fitur.


4. **Fitur Aplikasi**
```html
<section class="features-section" id="fitur">
    ...
    <div class="feature-card">📊 Dashboard Interaktif</div>
    <div class="feature-card">🔄 Manajemen CRUD</div>
    <div class="feature-card">🔔 Notifikasi Smart</div>
</section>
```
* Menjelaskan fitur-fitur utama aplikasi.
* Disajikan dengan icon dan deskripsi ringkas.

5. **Tentang Pembuat**
```html
<section class="about-section" id="about">
    ...
    <p>... dibuat oleh <strong>Khairun Nisa</strong>, NPM <strong>2308107010074</strong> dari kelas <strong>PBW B</strong></p>
    <img src="{{ asset('images/nisaa.jpg') }}" alt="Khairun Nisa">
</section>
```
* Bagian informasi singkat tentang pembuat aplikasi.
* Menampilkan nama, NPM, kelas, dan foto.


6. **Floating Effects dan JS**
```html
<script src="{{ asset('js/landing.js') }}"></script>
```
* Untuk efek partikel, animasi atau interaktivitas halaman.

## Kesimpulan Penjelasan
Landing page ini berfungsi sebagai **pengantar aplikasi ProMonitor**. Halaman ini:
* Memberikan informasi tentang fitur aplikasi.
* Menampilkan navigasi dasar dan tombol untuk login/daftar.
* Menjelaskan siapa pembuat aplikasinya.


## Penjelasan Halaman Register (`register.blade.php`)

**Fungsi**
Halaman **register** digunakan untuk membuat akun baru di aplikasi ProMonitor. Pengguna harus mengisi nama, email, password, dan konfirmasi password.


### Struktur Utama Kode
1. **Header & Aset**
```html
<head>
  ...
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
  <link href="https://cdnjs.cloudflare.com/...font-awesome..." rel="stylesheet">
</head>
```
* Mengimpor file CSS dan ikon.
* Menyisipkan token CSRF untuk keamanan pengiriman form.

2. **Navigasi Kembali**
```html
<a href="{{ route('landing') }}" class="back-arrow">
  <i class="fas fa-arrow-left"></i>
</a>
```
* Menyediakan tombol kembali ke halaman landing.

3. **Form Pendaftaran**
```html
<form method="POST" action="{{ route('register') }}">
  @csrf
  ...
</form>
```
* Form mengirim data ke route `register`.
* Menggunakan `@csrf` untuk keamanan token Laravel.

4. **Input Form**
```html
<input type="text" name="name" ... value="{{ old('name') }}" required>
@error('name') <span>{{ $message }}</span> @enderror
```
* Field input untuk **nama, email, password, konfirmasi password**.
* Validasi Laravel menampilkan pesan kesalahan jika input tidak valid.

5. **Tombol & Link Tambahan**
```html
<button type="submit" class="btn">Daftar Sekarang</button>
<p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
```
* Tombol submit untuk daftar akun.
* Tautan menuju halaman login.


## Penjelasan Halaman Login (`login.blade.php`)

**Fungsi**
Halaman **login** memungkinkan pengguna yang sudah terdaftar untuk masuk ke dashboard dan mengelola proyek mereka.


### Struktur Utama Kode

1. **Header & Aset**
* Sama dengan halaman register, menggunakan `landing.css` dan ikon dari Font Awesome.

2. **Navigasi Kembali**
```html
<a href="{{ route('landing') }}" class="back-arrow">...</a>
```
* Navigasi ke halaman utama landing.

3. **Form Login**
```html
<form method="POST" action="{{ route('login') }}">
  @csrf
  ...
</form>
```
* Form login mengirim email dan password ke route `login`.

4. **Input Login**
```html
<input type="email" name="email" ...>
<input type="password" name="password" ...>
```
* Field login yang wajib diisi.
* Menyediakan validasi kesalahan menggunakan `@error`.

5. **Tombol & Link Daftar**
```html
<button type="submit" class="btn">Masuk Sekarang</button>
<p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
```
* Tombol login.
* Tautan untuk pengguna baru agar menuju halaman register.


## Kesimpulan

* **Register** digunakan untuk membuat akun baru, lengkap dengan validasi Laravel.
* **Login** digunakan untuk mengakses sistem, hanya dengan email dan password.
* Keduanya dirancang dengan gaya desain yang konsisten dan ringan, serta mendukung **navigasi cepat ke landing** dan antar-form.

Mantap! Ini struktur `dashboard.blade.php`-nya sudah sangat rapi dan clean. Sekarang saya buatkan penjelasan untuk halaman **Dashboard** sebagai bagian lanjutan dari dokumentasi atau README kamu:

---

## Penjelasan Halaman Dashboard (`dashboard/index.blade.php`)

**Fungsi**
Halaman **dashboard** merupakan halaman utama setelah login, tempat pengguna melihat gambaran umum proyek mahasiswa, termasuk statistik dan akses cepat untuk melihat atau menambahkan proyek.


### Struktur Utama Kode
1. **Extends Layout & Judul**
```blade
@extends('layouts.app')
@section('title', 'Dashboard - Sistem Pemantauan Proyek')
```
* Menggunakan layout utama `app.blade.php`.
* Menyisipkan judul halaman ke tag `<title>` secara dinamis.

2. **Hero Section (Sambutan Pengguna)**
```blade
<h1 class="page-title">Sistem Pemantauan Proyek Mahasiswa</h1>
<p class="hero-text">Selamat datang... memungkinkan Anda untuk memonitor kemajuan proyek...</p>
<a href="{{ route('projects.index') }}" class="btn">Lihat Semua Proyek</a>
<a href="{{ route('projects.create') }}" class="btn">Tambah Proyek Baru</a>
```
* Sambutan kepada pengguna dengan penjelasan tujuan aplikasi.
* Tombol navigasi cepat:
  * **Lihat Semua Proyek**: menuju halaman daftar proyek.
  * **Tambah Proyek Baru**: langsung ke form input proyek.


3. **Statistik Proyek**

```blade
<div class="statistics-section">
  <div class="stat-item">
    <div class="stat-number">{{ $statistics['total'] }}</div>
    <div class="stat-label">Total Proyek</div>
  </div>
  ...
</div>
```

* Menampilkan ringkasan statistik proyek yang dihitung di controller:
  * **Total Proyek**
  * **Proyek Selesai**
  * **Proyek Aktif**
  * **Proyek Dalam Progress**
* Data ini dikirim dari controller melalui array `$statistics`.
Contoh di controller (`DashboardController` misalnya):
```php
$statistics = [
    'total' => Project::count(),
    'completed' => Project::where('status', 'Selesai')->count(),
    'active' => Project::where('status', 'Aktif')->count(),
    'progress' => Project::where('status', 'Progress')->count(),
];
```

## Kesimpulan
Halaman **Dashboard** adalah pusat kendali pengguna setelah login, yang menyajikan:
* Informasi sambutan dan penjelasan.
* Tombol cepat untuk mengelola proyek.
* Statistik real-time proyek dari database.
Halaman ini menjadi penghubung utama ke seluruh fitur CRUD ProMonitor.


## Halaman Daftar Proyek (`projects/index.blade.php`)

**Fungsi**
Halaman ini merupakan inti dari fitur manajemen proyek. Pengguna dapat:
* Melihat semua proyek yang sudah dibuat.
* Mencari proyek berdasarkan kata kunci.
* Menambahkan, mengedit, menghapus, serta mengganti status proyek secara langsung.


### Struktur Utama Halaman
1. **Layout & Asset**
```blade
@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endpush
```
* Menggunakan layout utama `layouts.app`.
* Menyisipkan CSS custom dan library eksternal (Bootstrap, FontAwesome).

2. **Header dan Notifikasi**
```blade
<h1>Daftar Proyek</h1>
@if(session('success')) ... @endif
```
* Judul halaman dengan ikon proyek.
* Menampilkan notifikasi sukses atau error berdasarkan session.

3. **Pencarian dan Tombol Tambah**
```blade
<form method="GET" action="{{ route('projects.index') }}">
    <input type="text" name="q" value="{{ request('q') }}">
</form>
<button id="add-project-btn">Tambah Proyek Baru</button>
```
* Fitur pencarian proyek.
* Tombol “Tambah Proyek Baru” untuk memunculkan form.

4. **Form Tambah/Edit Proyek (Tersembunyi Default)**
```blade
<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <input name="title" ...>
    <input name="start_date" type="date">
    ...
</form>
```
* Satu form dinamis dipakai untuk tambah dan edit proyek.
* Diatur tampil/sembunyi via JavaScript (`projects.js`).

5. **Tabel Proyek**
```blade
<table>
    <thead>...</thead>
    <tbody>
        @forelse($projects as $project)
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->description }}</td>
                ...
                <td>
                    <form method="POST" action="{{ route('projects.updateStatus', $project->id) }}">
                        <select name="status">...</select>
                    </form>
                </td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                        @csrf
                        @method('DELETE')
                        <button>Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            ...
        @endforelse
    </tbody>
</table>
```
* Menampilkan daftar proyek beserta tombol aksi:
  * **Detail** (jika fitur detail diimplementasi)
  * **Edit** → membuka form edit dengan data terisi.
  * **Hapus** → konfirmasi lalu hapus.
* Update status langsung di tabel via dropdown + submit otomatis.

6. **Empty State**
```blade
@if($projects->isEmpty())
<div id="emptyState">Belum ada proyek</div>
@endif
```
* Ditampilkan bila tidak ada data proyek.
* Dilengkapi ilustrasi dan tombol "Tambah Proyek Baru".

7. **Pagination**
```blade
@if($projects->hasPages())
    {{ $projects->appends(request()->query())->links() }}
@endif
```
* Navigasi halaman jika data proyek cukup banyak.


8. **Data untuk JavaScript**
```blade
<script>
    window.projectsData = @json(...);
    window.csrfToken = '{{ csrf_token() }}';
    window.baseUrl = '{{ url('/') }}';
</script>
```
* Mengirim data proyek dari server ke JavaScript (`projects.js`) untuk interaksi front-end.
* Kompatibel dengan data paginasi maupun koleksi biasa.


###  Fitur JavaScript (`projects.js`)
> **Catatan:** File ini mengatur:
* Tampilkan/sembunyikan form tambah/edit.
* Prefill form saat tombol “Edit” ditekan.
* AJAX status update jika diperlukan.
* Validasi tambahan / UX enhancements.


### Kesimpulan
Halaman **`projects/index.blade.php`** adalah jantung dari sistem CRUD proyek. Didukung form dinamis, tabel interaktif, empty state ramah pengguna, dan data yang siap digunakan di front-end, halaman ini:
* Menggabungkan fungsionalitas dengan UX modern.
* Mengandalkan integrasi Laravel + Blade + JavaScript modular.



Controller Utama
1. AuthController
   Menangani login, register, logout, dan landing page.
2. DashboardController
   Mengambil dan menampilkan data proyek pengguna saat ini.
3. ProjectController
   Menyediakan fungsi CRUD proyek dan update status.
4. ProfileController
   Mengelola informasi pengguna: data profil, password, foto profil, dan penghapusan akun.

Model
1. User:
    public function projects() {
    return $this->hasMany(Project::class);
}
   
2. Project:
    public function user() {
    return $this->belongsTo(User::class);
}


**Penjelasan Antarmuka Pengguna (User Interface)**
1. Landing Page
    ![image](https://github.com/user-attachments/assets/253de7b2-e3fe-4b13-9e52-2c7aafa09771)
    Halaman awal aplikasi yang memperkenalkan fitur utama dan mengarahkan pengguna ke login atau registrasi.

2. Register Page
   ![image](https://github.com/user-attachments/assets/b05963bf-79c2-442b-9a8a-dac63d553f41)
    Form pendaftaran akun baru untuk mahasiswa.

3. Login Page
    ![image](https://github.com/user-attachments/assets/9efc4032-815a-4c36-8fa8-2d3f90cada05)
   Form untuk pengguna yang sudah terdaftar masuk ke sistem.

4. Dashboard
    ![image](https://github.com/user-attachments/assets/d666a3e7-0c3d-4a40-9ff1-9558503a39f0)
   Halaman utama setelah login, menampilkan statistik proyek yang dibuat oleh pengguna.

5. Halaman Proyek
    ![image](https://github.com/user-attachments/assets/10bdfc79-72fa-499f-9ca4-a75be5e4793a)
   Halaman untuk melihat daftar proyek, serta membuat, mengedit, menghapus proyek, dan mengubah status proyek.

6. Halaman Profil
    ![image](https://github.com/user-attachments/assets/43cdbc74-9fb1-4d1d-84cb-7b69f0847299)
   Pengguna dapat memperbarui data pribadi, mengunggah/menghapus foto profil, mengganti kata sandi, atau menghapus akun mereka.


 **Cara Instalasi Aplikasi**
1. Clone repository ini:
    git clone https://github.com/username/promonitoring.git
    cd promonitoring
2. Install dependensi backend dan frontend:
    composer install
    npm install
    npm run dev
3. Copy file .env dan buat key aplikasi:
    cp .env.example .env
    php artisan key:generate 
4. Atur konfigurasi database di file .env sesuai kebutuhan.
5. Migrasi dan seed database:
   php artisan migrate --seed
6. Jalankan aplikasi di server lokal:
   php artisan serve
7. Akses aplikasi di browser pada:
    http://127.0.0.1:8000
