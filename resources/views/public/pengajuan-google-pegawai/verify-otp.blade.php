@extends('public.layouts.public')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="container py-5">
    <div class="card shadow p-4" style="border-radius: 1rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="background: linear-gradient(90deg, #b31217 0%, #7b1f23 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Verifikasi OTP</h3>
        </div>
        
        @php
            $maskedPhone = substr($noHp, 0, 6) . '****' . substr($noHp, -2);
        @endphp

        <div class="text-center mb-4">
            <p class="text-muted">Kami telah mengirimkan kode OTP ke nomor <strong>{{ $maskedPhone }}</strong>.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <form action="{{ route('pegawai.verifyOtp.submit') }}" method="POST">
            @csrf
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-key text-danger"></i></span>
                    <input type="text" name="otp" placeholder="Masukkan Kode OTP" class="form-control shadow-none" required>
                </div>
                @error('otp')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn w-100 py-2" style="background: linear-gradient(135deg, #b31217 0%, #7b1f23 100%); color: white; border-radius: 8px; font-weight: 600; transition: all 0.3s;">
                Verifikasi OTP
            </button>
        </form>
        
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">Tidak menerima kode? <a href="#" style="color: #b31217; text-decoration: none;">Kirim Ulang</a></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .form-control:focus {
        border-color: #b31217;
        box-shadow: 0 0 0 0.25rem rgba(179, 18, 23, 0.25);
    }
</style>
@endpush
