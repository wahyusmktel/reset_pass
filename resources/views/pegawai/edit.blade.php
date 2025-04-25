@extends('layouts.app')

@section('title', 'Edit Data Guru')

@section('content')
    <h1 class="mb-3">Edit Data Guru</h1>

    <a href="{{ route('guru.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" name="nama_guru" id="nama_guru"
                class="form-control @error('nama_guru') is-invalid @enderror"
                value="{{ old('nama_guru', $guru->nama_guru) }}" required>
            @error('nama_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email_guru" class="form-label">Email Guru</label>
            <input type="email" name="email_guru" id="email_guru"
                class="form-control @error('email_guru') is-invalid @enderror"
                value="{{ old('email_guru', $guru->email_guru) }}" required>
            @error('email_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip', $guru->nip) }}" required>
            @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
