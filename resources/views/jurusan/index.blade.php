@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
    <h1 class="mb-3">Data Jurusan</h1>

    <a href="{{ route('jurusan.create') }}" class="btn btn-primary mb-3">+ Tambah Jurusan</a>

    <form action="{{ route('jurusan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama atau kode jurusan...">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Nama Jurusan</th>
                <th>Kode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurusans as $jurusan)
                <tr>
                    <td>{{ $jurusan->nama_jurusan }}</td>
                    <td>{{ $jurusan->kode_jurusan }}</td>
                    <td>
                        <a href="{{ route('jurusan.edit', $jurusan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $jurusans->links() }}
@endsection
