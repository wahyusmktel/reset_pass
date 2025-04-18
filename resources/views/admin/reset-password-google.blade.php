@extends('layouts.app') {{-- atau sesuaikan dengan layout kamu --}}

@section('content')
    <div class="container">
        <h2 class="mb-4">Reset Password Akun Google Siswa</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.reset-google-password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Siswa</label>
                <input type="email" name="email" class="form-control" required
                    placeholder="contoh: siswa@smktelkom-lpg.sch.id">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="text" name="password" class="form-control" required placeholder="Minimal 6 karakter">
            </div>

            <button type="submit" class="btn btn-danger">Reset Password</button>
        </form>
    </div>
@endsection
