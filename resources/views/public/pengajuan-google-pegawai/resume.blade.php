@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4 text-center">Berhasil Mengajukan Reset</h3>

        <div class="card shadow-sm p-4">
            <p><strong>Nama Pegawai:</strong> {{ $pegawai->nama_guru }}</p>
            <p><strong>NIP:</strong> {{ $pegawai->nip }}</p>
            <p><strong>Email Lama:</strong> {{ $pegawai->email_guru }}</p>
            <p><strong>Jabatan:</strong> {{ $pegawai->jabatan }}</p>

            <div class="alert alert-success mt-4">
                Pengajuan reset akun Google telah berhasil dikirim. Silakan tunggu proses verifikasi oleh admin.
            </div>
        </div>
    </div>
@endsection
