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

    <!-- Tombol Trigger Modal -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
        Import Pegawai
    </button>

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

    <!-- Modal Import Pegawai -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                            <small class="text-muted">Format: .xlsx, .xls, .csv</small>
                        </div>
                        <div>
                            <a href="{{ asset('template/template_import_pegawai.xlsx') }}" class="btn btn-link p-0">📄
                                Download Template Excel</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
