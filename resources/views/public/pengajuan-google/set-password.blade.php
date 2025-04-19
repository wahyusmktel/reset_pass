@extends('public.layouts.public')

@section('title', 'Set Password Baru')

@section('content')
    <div class="container py-5">
        <div class="card shadow p-4">
            <h3 class="mb-4">Reset Password untuk: {{ $siswa->nama }}</h3>

            {{-- GLOBAL ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('pengajuan-google.update-password', $pengajuan->id) }}" method="POST">
                @csrf

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Buat Password Baru</label>
                    <div class="input-group">
                        <input type="text" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                            required>
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="generatePassword()">Generate</button>
                        <button type="button" class="btn btn-outline-success" onclick="copyPassword()">Copy</button>
                    </div>
                    <small>Gunakan tombol <b>Generate</b> diatas untuk apabila anda ingin membuat password secara
                        random</small>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KONFIRMASI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ketik Ulang Password Baru</label>
                    <input type="text" name="password_confirmation" id="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generatePassword() {
            const random = Math.random().toString(36).slice(-8);
            document.getElementById('password').value = random;
            document.getElementById('password_confirmation').value = random;
        }

        function copyPassword() {
            const input = document.getElementById('password');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
    </script>
@endpush
