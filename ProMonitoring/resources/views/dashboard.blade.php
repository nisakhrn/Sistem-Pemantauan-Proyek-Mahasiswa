{{-- resources/views/dashboard/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pemantauan Proyek')

@section('content')
<div class="dashboard-page">
    <h1 class="page-title">Sistem Pemantauan Proyek Mahasiswa</h1>
    
    <div class="hero-section">
        <p class="hero-text">
            Selamat datang di Sistem Pemantauan Proyek Mahasiswa! 🎓<br>
            Platform ini memungkinkan Anda untuk memonitor kemajuan proyek mahasiswa dengan mudah,
            termasuk pembuatan, pembaruan, dan penghapusan proyek secara efisien.
        </p>
        <a href="{{ route('projects.index') }}" class="btn">Lihat Semua Proyek</a>
        <a href="{{ route('projects.create') }}" class="btn">Tambah Proyek Baru</a>
    </div>
    
    <div class="statistics-section">
        <div class="project-card">
            <div class="project-title">📊 Statistik Proyek</div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $statistics['total'] }}</div>
                    <div class="stat-label">Total Proyek</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $statistics['completed'] }}</div>
                    <div class="stat-label">Proyek Selesai</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $statistics['active'] }}</div>
                    <div class="stat-label">Proyek Aktif</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $statistics['progress'] }}</div>
                    <div class="stat-label">Dalam Progress</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection