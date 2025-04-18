@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
    <h1 class="mb-3">
        Edit Jurusan</h1>
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

    <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST" class="card p-4 shadow bg-white">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" class="form-control"
                value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" class="form-control"
                value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
