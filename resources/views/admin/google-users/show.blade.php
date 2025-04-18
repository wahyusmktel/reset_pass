@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <h1 class="mb-4">Detail Pengguna Google Workspace</h1>

    <div class="card shadow-sm">
        <div class="card-body d-flex">
            <img src="{{ $user['photo_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) }}"
                class="rounded me-4" width="100" height="100" alt="Foto Profil">
            <div>
                <h4>{{ $user['name'] }}</h4>
                <p class="mb-1"><strong>Email:</strong> {{ $user['email'] }}</p>
                <p class="mb-1"><strong>Admin:</strong> {{ $user['is_admin'] ? 'Ya' : 'Tidak' }}</p>
                <p class="mb-1"><strong>Status:</strong>
                    <span class="badge {{ $user['suspended'] ? 'bg-danger' : 'bg-success' }}">
                        {{ $user['suspended'] ? 'Suspended' : 'Aktif' }}
                    </span>
                </p>
                <p><strong>Terakhir Login:</strong>
                    {{ $user['last_login'] ? \Carbon\Carbon::parse($user['last_login'])->format('d M Y H:i') : '-' }}</p>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.google.users') }}" class="btn btn-secondary mt-3">← Kembali</a>
@endsection
