@extends('layouts.app')

@section('title', 'Reset Akun Google')

@section('content')
    <h2 class="mb-4">Response Reset Password Akun Google</h2>

    <div class="card p-4 shadow-sm">
        <form action="{{ route('pengajuan-google.response.store', $pengajuan->id) }}" method="POST">
            @csrf
            <p><strong>Nama:</strong> {{ $pengajuan->siswa->nama }}</p>
            <p><strong>Email Lama:</strong> {{ $pengajuan->siswa->email }}</p>
            <p><strong>No HP:</strong> {{ $pengajuan->siswa->no_hp }}</p>

            <div class="mb-3">
                <label for="email_baru" class="form-label">Email Baru</label>
                <input type="email" name="email_baru" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="text" name="password_baru" class="form-control" required>
            </div>

            <button class="btn btn-primary">Simpan Response</button>
        </form>
    </div>
@endsection
