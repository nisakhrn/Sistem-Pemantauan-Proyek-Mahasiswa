@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Profil Pengguna</h1>
                    <p class="mb-0 text-muted">Kelola informasi akun Anda</p>
                </div>
            </div>

            <div class="row">
                <!-- Profile Card -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card profile-card">
                        <div class="card-body text-center">
                            <!-- Profile Picture -->
                            <div class="profile-img-container mb-3">
                                <img src="{{ Auth::user()->profile_picture ?? asset('images/default-avatar.png') }}" 
                                     alt="Profile Picture" 
                                     class="profile-img"
                                     id="profileImage">
                                <div class="profile-img-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                            </div>
                            
                            <!-- User Info -->
                            <h4 class="profile-name">{{ Auth::user()->name }}</h4>
                            <p class="profile-email text-muted">{{ Auth::user()->email }}</p>
                            <p class="profile-joined text-muted">
                                <i class="fas fa-calendar-alt"></i>
                                Bergabung {{ Auth::user()->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Profile Settings -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Pengaturan Akun</h5>
                        </div>
                        <div class="card-body">
                            <!-- Update Profile Form -->
                            <form id="updateProfileForm" class="mb-4">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="{{ Auth::user()->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="{{ Auth::user()->email }}" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </form>

                            <hr>

                            <!-- Change Password Section -->
                            <div class="password-section">
                                <h6 class="mb-3">Ubah Kata Sandi</h6>
                                <form id="changePasswordForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_password">Kata Sandi Saat Ini</label>
                                                <input type="password" class="form-control" id="current_password" 
                                                       name="current_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_password">Kata Sandi Baru</label>
                                                <input type="password" class="form-control" id="new_password" 
                                                       name="new_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_password_confirmation">Konfirmasi Kata Sandi</label>
                                                <input type="password" class="form-control" id="new_password_confirmation" 
                                                       name="new_password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key"></i> Ubah Kata Sandi
                                    </button>
                                </form>
                            </div>

                            <hr>

                            <!-- Danger Zone -->
                            <div class="danger-zone">
                                <h6 class="text-danger mb-3">Zona Berbahaya</h6>
                                <p class="text-muted mb-3">
                                    Setelah akun Anda dihapus, semua data akan dihapus secara permanen. 
                                    Pastikan Anda yakin sebelum melanjutkan.
                                </p>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
                                    <i class="fas fa-trash-alt"></i> Hapus Akun
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Hapus Akun
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun ini?</p>
                <p class="text-danger">
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. 
                    Semua data Anda akan dihapus secara permanen.
                </p>
                <form id="deleteAccountForm">
                    @csrf
                    <div class="form-group">
                        <label for="delete_password">Masukkan kata sandi untuk konfirmasi:</label>
                        <input type="password" class="form-control" id="delete_password" 
                               name="password" required placeholder="Kata sandi Anda">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAccount">
                    <i class="fas fa-trash-alt"></i> Ya, Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection