@extends('layouts.app')

@section('title', 'Reset Akun MyLMS')

@section('content')
    <h2 class="mb-4">Response Reset Akun MyLMS</h2>

    <div class="card p-4 shadow-sm">
        <form action="{{ route('pengajuan-mylms.response.store', $pengajuan->id) }}" method="POST">
            @csrf

            <p><strong>Nama:</strong> {{ $pengajuan->siswa->nama }}</p>
            <p><strong>Email:</strong> {{ $pengajuan->siswa->email }}</p>
            <p><strong>No HP:</strong> {{ $pengajuan->siswa->no_hp }}</p>

            <div class="mb-3">
                <label for="username_baru" class="form-label">Username Baru</label>
                <input type="text" name="username_baru" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="text" name="password_baru" class="form-control" required>
            </div>

            <button class="btn btn-primary">Simpan Response</button>
        </form>
    </div>
@endsection
