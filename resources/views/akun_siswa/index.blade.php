@extends('layouts.app')

@section('title', 'Generate Akun Siswa')

@section('content')
    <h1 class="mb-4">Generate Akun Login Siswa</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('akun-siswa.generate') }}" method="POST" class="card p-4 shadow-sm bg-white mb-4">
        @csrf
        <div class="mb-3">
            <label for="siswa_id" class="form-label">Pilih Siswa</label>
            <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->nis }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password Akun</label>
            <input type="text" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        </div>
        <button class="btn btn-primary">Generate Akun</button>
    </form>
@endsection
