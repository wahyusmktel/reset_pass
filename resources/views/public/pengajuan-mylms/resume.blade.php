@extends('public.layouts.public')

@section('title', 'Resume Pengajuan MyLMS')

@section('content')

<style>
    .btn-primary {
        background: linear-gradient(90deg, #b31217 0%, #7b1f23 100%);
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .btn-primary:hover, .btn-primary:focus {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 16px rgba(179,18,23,0.15);
        background: linear-gradient(90deg, #7b1f23 0%, #b31217 100%);
    }
    .btn-link {
        color: #b31217 !important;
        transition: color 0.2s;
    }
    .btn-link:hover {
        color: #7b1f23 !important;
        text-decoration: underline;
    }
    .gradient-title {
        background: linear-gradient(90deg, #b31217 0%, #7b1f23 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        display: inline-block;
    }
    .animate-fadein {
        opacity: 0;
        transform: translateY(24px) scale(0.98);
        animation: fadeInSlide 0.9s cubic-bezier(.68,-0.55,.27,1.55) 0.1s forwards;
    }
    @keyframes fadeInSlide {
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>

<div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="w-100" style="max-width: 480px;">
        <div class="text-center mb-4">
            <img src="https://img.icons8.com/color/96/000000/learning.png" alt="MyLMS Logo" style="width:64px;height:64px;">
            <h2 class="fw-bold mt-3 mb-2 gradient-title animate-fadein">Pengajuan Reset Akun MyLMS Berhasil</h2>
            <p class="text-muted mb-0"><span id="typing-text"></span></p>
        </div>
        <div class="card shadow rounded-4 border-0 p-4 bg-white">
            <div class="mb-3">
                <span class="fw-semibold">Nama:</span> <span class="float-end">{{ $data->siswa->nama }}</span>
            </div>
            <div class="mb-3">
                <span class="fw-semibold">NIS:</span> <span class="float-end">{{ $data->siswa->nis }}</span>
            </div>
            <div class="mb-3">
                <span class="fw-semibold">No HP:</span> <span class="float-end">{{ $data->siswa->no_hp }}</span>
            </div>
            <div class="mb-3">
                <span class="fw-semibold">Alasan:</span> <span class="float-end">{{ $data->keterangan ?? '-' }}</span>
            </div>
            <div class="mb-4">
                <span class="fw-semibold">Status Pengajuan:</span>
                <span class="badge bg-warning text-dark ms-2">Diajukan</span>
            </div>
            <div class="alert alert-secondary rounded-3 mt-3 mb-0" style="font-size:0.97rem; text-align:justify; background:#6c757d; color:#fff; border:none;">
                <strong>Informasi:</strong> Pengajuan reset password Anda sedang diproses oleh admin.
                Setelah proses selesai, password baru akan dikirimkan melalui pesan WhatsApp ke nomor yang Anda masukkan di atas.
                Pastikan nomor tersebut aktif dan dapat dihubungi.
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('landing') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var text = "Data pengajuan Anda telah diterima dan sedang diproses.";
        var i = 0;
        var speed = 32;
        var typingTarget = document.getElementById("typing-text");
        function typeWriter() {
            if (i < text.length) {
                typingTarget.innerHTML += text.charAt(i);
                i++;
                setTimeout(typeWriter, speed);
            }
        }
        typeWriter();
    });
</script>
