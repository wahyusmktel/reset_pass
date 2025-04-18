@extends('layouts.app')

@section('title', 'Data Rombel')

@section('content')
    <h1 class="mb-3">Data Rombel</h1>

    <a href="{{ route('rombel.create') }}" class="btn btn-primary mb-3">+ Tambah Rombel</a>
    <a href="{{ route('rombel.generate') }}" class="btn btn-primary mb-3">
        <i class="fas fa-magic me-1"></i> Generate Rombel Otomatis
    </a>

    <form action="{{ route('rombel.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama siswa atau kelas...">
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
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rombels as $rombel)
                <tr>
                    <td>{{ $rombel->siswa->nama ?? '-' }}</td>
                    <td>{{ $rombel->kelas->nama_kelas ?? '-' }}</td>
                    <td>
                        <a href="{{ route('rombel.edit', $rombel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('rombel.destroy', $rombel->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $rombels->links() }}
@endsection
