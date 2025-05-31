@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Proyek Baru</h1>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Judul Proyek</label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-input" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-input" value="{{ old('start_date') }}" required>
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-input" required>
                    <option value="progress">Progress</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <button type="submit" class="btn">Simpan Proyek</button>
        </form>
    </div>
@endsection
