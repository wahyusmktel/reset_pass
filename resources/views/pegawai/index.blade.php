@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
    <h1 class="mb-3">Data Pegawai</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('pegawai.index') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="Cari nama, email, nip...">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary">+ Tambah Pegawai</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Nama Guru</th>
                <th>Email Guru</th>
                <th>NIP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawais as $pegawai)
                <tr>
                    <td>{{ $pegawai->nama_guru }}</td>
                    <td>{{ $pegawai->email_guru }}</td>
                    <td>{{ $pegawai->nip }}</td>
                    <td>
                        @if ($pegawai->status)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin hapus guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data guru tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $pegawais->links() }}
@endsection
