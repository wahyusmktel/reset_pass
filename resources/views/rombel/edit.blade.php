@extends('layouts.app')

@section('title', 'Edit Rombel')

@section('content')
    <h1 class="mb-3">
        Edit Rombel</h1>
    <a href="{{ route('rombel.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rombel.update', $rombel->id) }}" method="POST" class="card p-4 shadow bg-white">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Siswa</label>
            <select name="siswa_id" class="form-select" required>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}"
                        {{ old('siswa_id', $rombel->siswa_id) == $siswa->id ? 'selected' : '' }}>
                        {{ $siswa->nama }} ({{ $siswa->nis }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select" required>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kelas_id', $rombel->kelas_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
