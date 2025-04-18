@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <h1 class="mb-3">Data Siswa</h1>

    <a href="{{ route('siswa.create') }}" class="btn btn-primary mb-3">+ Tambah Siswa</a>
    <a href="{{ route('siswa.generate-akun-masal') }}" class="btn btn-success mb-3"
        onclick="return confirm('Yakin ingin generate akun semua siswa yang belum punya akun?')">
        🔁 Generate Akun Masal
    </a>

    <form action="{{ route('siswa.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Cari nama, NIS, NISN, email...">
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
                <th>Nama</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nisn }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td>{{ $siswa->no_hp }}</td>
                    <td>{{ $siswa->password }}</td>
                    <td>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @if ($siswa->user)
                            <form action="{{ route('siswa.reset-password', $siswa->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-secondary"
                                    onclick="return confirm('Reset password untuk {{ $siswa->nama }}?')">
                                    Reset Password
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $siswas->links() }}
@endsection
