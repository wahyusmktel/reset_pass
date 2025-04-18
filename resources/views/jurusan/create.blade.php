@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')
    <h1 class="mb-3">
        Tambah Jurusan</h1>
    <a href="{{ route('jurusan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jurusan.store') }}" method="POST" class="card p-4 shadow bg-white">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" class="form-control" value="{{ old('nama_jurusan') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" class="form-control" value="{{ old('kode_jurusan') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
