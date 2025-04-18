@extends('layouts.app')

@section('title', 'Pengajuan Reset Google')

@section('content')
    <h1 class="mb-4">Data Pengajuan Reset Google</h1>

    <a href="{{ route('pengajuan-google.create') }}" class="btn btn-primary mb-3">+ Tambah Pengajuan</a>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama siswa...">
        </div>
        <div class="col-md-3">
            <select name="status_pengajuan" class="form-select">
                <option value="">-- Semua Status Pengajuan --</option>
                <option value="1" {{ request('status_pengajuan') === '1' ? 'selected' : '' }}>Diajukan</option>
                <option value="0" {{ request('status_pengajuan') === '0' ? 'selected' : '' }}>Response</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status_wa" class="form-select">
                <option value="">-- Semua Status WA --</option>
                <option value="1" {{ request('status_wa') === '1' ? 'selected' : '' }}>Sudah Kirim WA</option>
                <option value="0" {{ request('status_wa') === '0' ? 'selected' : '' }}>Belum Kirim WA</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Nama Siswa</th>
                <th>Keterangan</th>
                <th>Status Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        @if ($item->status_pengajuan)
                            <span class="badge bg-success">Diajukan</span>
                        @else
                            <span class="badge bg-secondary">Response</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pengajuan-google.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('pengajuan-google.response.form', $item->id) }}"
                            class="btn btn-sm btn-success">Reset</a>
                        <form action="{{ route('pengajuan-google.destroy', $item->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @if (!$item->status_pengajuan && $item->siswa && $item->response && !$item->response->sudah_kirim_wa)
                            @php
                                $hp = ltrim($item->siswa->no_hp, '0');
                                $wa = '62' . $hp;

                                $message = urlencode("
Halo, berikut ini adalah akun Google sekolah Anda yang telah direset:

Nama: {$item->siswa->nama}
NIS: {$item->siswa->nis}
Email Baru: {$item->response->email_baru}
Password Baru: {$item->response->password_baru}

Silakan login menggunakan akun di atas. Jika ada kendala, segera hubungi admin.
");
                                $waLink = "https://api.whatsapp.com/send?phone=$wa&text=$message";
                            @endphp

                            <form action="{{ route('pengajuan-google.kirim-wa', $item->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-outline-success">Kirim
                                    WA</a>
                                <button type="submit" class="btn btn-sm btn-outline-secondary"
                                    onclick="return confirm('Tandai sebagai sudah kirim WA?')">
                                    ✔ Tandai Kirim WA
                                </button>
                            </form>
                        @elseif($item->response && $item->response->sudah_kirim_wa)
                            <span class="badge bg-success">Sudah Kirim WA</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links() }}
@endsection
