@extends('layouts.app')

@section('title', 'Manajemen Proyek - Sistem Pemantauan Proyek')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.css" rel="stylesheet">
@endpush

@section('content')
<div class="projects-page">
    <div class="main-card">
        <!-- Header -->
        <div class="card-header">
            <h1 class="page-title">
                <i class="fas fa-project-diagram me-3"></i>
                Daftar Proyek
            </h1>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search and Add Section -->
        <div class="search-section">
            <form class="d-flex align-items-center w-100" id="searchForm" method="GET" action="{{ route('projects.index') }}">
                <div class="search-container me-2">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari Project" class="search-input">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </form>
            <button class="btn-add ms-2" id="add-project-btn">
                <i class="fas fa-plus me-2"></i>
                Tambah Proyek Baru
            </button>
        </div>

        <!-- Add/Edit Project Form -->
        <div class="card" id="project-form-card" style="display: none;">
            <div class="project-form">
                <h3 id="form-title">Tambah Proyek Baru</h3>
                <form action="{{ route('projects.store') }}" method="POST" id="project-form">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="project_id" id="project-id" value="">
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="project-title" class="form-label">
                                <i class="fas fa-heading me-1"></i>
                                Judul Proyek <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="project-title" name="title" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="project-description" class="form-label">
                                <i class="fas fa-align-left me-1"></i>
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="project-description" name="description" rows="3" required></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="start-date" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Tanggal Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="start-date" name="start_date" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end-date" class="form-label">
                                <i class="fas fa-calendar-check me-1"></i>
                                Tanggal Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="end-date" name="end_date" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="project-status" class="form-label">
                                <i class="fas fa-flag me-1"></i>
                                Status
                            </label>
                            <select class="form-select" id="project-status" name="status">
                                <option value="progress" selected>Progress</option>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary" id="save-btn">
                            <i class="fas fa-save me-1"></i>
                            Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" id="cancel-btn">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="project-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-folder me-2"></i>Judul Proyek</th>
                            <th><i class="fas fa-file-text me-2"></i>Deskripsi</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Tanggal Mulai</th>
                            <th><i class="fas fa-calendar-check me-2"></i>Tanggal Selesai</th>
                            <th><i class="fas fa-tasks me-2"></i>Status</th>
                            <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        @forelse($projects ?? [] as $project)
                            <tr data-project-id="{{ $project->id }}">
                                <td><strong>{{ $project->title }}</strong></td>
                                <td>{{ Str::limit($project->description, 50) }}</td>
                                <td>{{ $project->formatted_start_date }}</td>
                                <td>{{ $project->formatted_end_date }}</td>
                                <td>
                                    <form method="POST" action="{{ route('projects.updateStatus', $project->id) }}" class="d-inline status-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm status-badge status-{{ $project->status }}">
                                            @foreach(\App\Models\Project::getValidStatuses() as $value => $label)
                                                <option value="{{ $value }}" {{ $project->status == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-detail" data-project-id="{{ $project->id }}" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        <button class="btn-edit" data-project-id="{{ $project->id }}" title="Edit Proyek">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')" title="Hapus Proyek">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty state akan ditampilkan via JavaScript jika tidak ada data -->
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state" style="{{ ($projects ?? collect())->isEmpty() ? 'display: block;' : 'display: none;' }}">
                <div class="empty-illustration">
                    <i class="fas fa-folder-open empty-icon"></i>
                </div>
                <h3 class="empty-title">Belum ada proyek</h3>
                <p class="empty-description">Mulai dengan menambahkan proyek pertama Anda untuk memulai pemantauan</p>
                <button class="btn-add btn-empty-state" id="add-project-empty-btn">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Proyek Baru
                </button>
            </div>

            <!-- Pagination -->
            @if(isset($projects) && $projects->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $projects->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<!-- Hidden data for JavaScript -->
<script type="text/javascript">
    // PERBAIKAN: Cek apakah $projects adalah paginated atau collection biasa
    @if(isset($projects))
        @if(method_exists($projects, 'items'))
            // Jika paginated
            window.projectsData = @json($projects->items());
        @else
            // Jika collection biasa
            window.projectsData = @json($projects);
        @endif
    @else
        window.projectsData = [];
    @endif
    
    window.csrfToken = '{{ csrf_token() }}';
    window.baseUrl = '{{ url('/') }}';
    
    // Debug: Log data untuk memastikan struktur benar
    console.log('Projects data loaded:', window.projectsData);
</script>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/projects.js') }}"></script>
@endpush