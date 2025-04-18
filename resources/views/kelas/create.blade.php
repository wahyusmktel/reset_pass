@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
    <h1 class="mb-3">
        Tambah Kelas</h1>
    <a href="{{ route('kelas.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kelas.store') }}" method="POST" class="card p-4 shadow bg-white">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tingkat</label>
            <input type="text" name="tingkat_kelas" class="form-control" value="{{ old('tingkat_kelas') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan_id" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach ($jurusans as $j)
                    <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
