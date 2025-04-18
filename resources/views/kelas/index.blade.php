@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <h1 class="mb-3">Data Kelas</h1>

    <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">+ Tambah Kelas</a>

    <form action="{{ route('kelas.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama/tingkat kelas...">
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
                <th>Nama Kelas</th>
                <th>Tingkat</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelas as $k)
                <tr>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->tingkat_kelas }}</td>
                    <td>{{ $k->jurusan->nama_jurusan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $kelas->links() }}
@endsection
