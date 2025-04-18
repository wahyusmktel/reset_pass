@extends('layouts.app')

@section('title', 'Pengajuan Reset iGracias')

@section('content')
    <h1 class="mb-4">Data Pengajuan Reset iGracias</h1>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" class="form-control" value="{{ request('q') }}"
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
            <button class="btn btn-outline-secondary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Nama Siswa</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <span class="badge {{ $item->status_pengajuan ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->status_pengajuan ? 'Diajukan' : 'Response' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('pengajuan-igracias.response.form', $item->id) }}"
                            class="btn btn-sm btn-success">Reset</a>

                        @if (!$item->status_pengajuan && $item->response && !$item->response->sudah_kirim_wa)
                            @php
                                $hp = ltrim($item->siswa->no_hp, '0');
                                $wa = '62' . $hp;
                                $message = urlencode("
Halo, berikut akun iGracias Anda yang telah direset:

Nama: {$item->siswa->nama}
NIS: {$item->siswa->nis}
Username Baru: {$item->response->username_baru}
Password Baru: {$item->response->password_baru}

Silakan login dan jaga kerahasiaan akun Anda.
");
                                $waLink = "https://api.whatsapp.com/send?phone=$wa&text=$message";
                            @endphp
                            <form action="{{ route('pengajuan-igracias.kirim-wa', $item->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-outline-success">Kirim
                                    WA</a>
                                <button type="submit" class="btn btn-sm btn-outline-secondary"
                                    onclick="return confirm('Tandai sebagai sudah kirim WA?')">✔ Tandai Kirim WA</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links() }}
@endsection
