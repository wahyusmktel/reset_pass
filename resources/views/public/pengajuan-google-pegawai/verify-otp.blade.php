@php
    $maskedPhone = substr($noHp, 0, 6) . '****' . substr($noHp, -2);
@endphp

<p class="text-muted">Kami telah mengirimkan kode OTP ke nomor <strong>{{ $maskedPhone }}</strong>.</p>

<form action="{{ route('pegawai.verifyOtp.submit') }}" method="POST">
    @csrf
    <input type="text" name="otp" placeholder="Masukkan OTP" class="form-control mb-3" required>
    <button type="submit" class="btn btn-success">Verifikasi</button>
</form>
