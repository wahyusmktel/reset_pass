@extends('public.layouts.public')

@section('title', 'Verifikasi OTP')

@section('content')
    <div class="container py-5">
        <div class="card shadow p-4">
            <h3 class="mb-4">Verifikasi OTP</h3>

            <form method="POST" action="{{ route('pengajuan-google.verify-otp') }}">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                <div class="mb-3">
                    <label for="otp_code" class="form-label">Masukkan Kode OTP</label>
                    <input type="text" name="otp_code" id="otp_code"
                        class="form-control @error('otp_code') is-invalid @enderror" required>
                    @error('otp_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100">Verifikasi OTP</button>
            </form>
        </div>
    </div>
@endsection
