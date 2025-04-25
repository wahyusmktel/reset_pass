<!-- resources/views/guru/create.blade.php -->

@extends('layouts.app')

@section('title', 'Tambah Data Guru')

@section('content')
    <h1 class="mb-4">Tambah Data Guru</h1>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" name="nama_guru" id="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror"
                value="{{ old('nama_guru') }}" required>
            @error('nama_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email_guru" class="form-label">Email Guru</label>
            <input type="email" name="email_guru" id="email_guru"
                class="form-control @error('email_guru') is-invalid @enderror" value="{{ old('email_guru') }}" required>
            @error('email_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip') }}" required>
            @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
