@extends('layouts.app')

@section('title', 'Siswa per Rombel')

@section('content')
    <h1 class="mb-3">Lihat Siswa per Rombel</h1>

    <form action="{{ route('rombel.per-kelas') }}" method="GET" class="card p-3 shadow-sm mb-4 bg-white">
        <div class="row g-2 align-items-end">
            <div class="col-md-8">
                <label for="kelas_id" class="form-label">Pilih Kelas / Rombel</label>
                <select name="kelas_id" id="kelas_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kls)
                        <option value="{{ $kls->id }}" {{ $selectedKelasId == $kls->id ? 'selected' : '' }}>
                            {{ $kls->tingkat_kelas }} - {{ $kls->nama_kelas }} ({{ $kls->jurusan->nama_jurusan ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </div>
    </form>

    @if ($kelasTerpilih)
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <strong>{{ $kelasTerpilih->tingkat_kelas }} - {{ $kelasTerpilih->nama_kelas }}</strong>
                <span class="badge bg-secondary float-end">{{ $kelasTerpilih->jurusan->nama_jurusan ?? '-' }}</span>
            </div>
            <div class="card-body p-0">
                @if ($rombels->count() > 0)
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Email</th>
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rombels as $index => $rombel)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rombel->siswa->nama }}</td>
                                    <td>{{ $rombel->siswa->nis }}</td>
                                    <td>{{ $rombel->siswa->nisn }}</td>
                                    <td>{{ $rombel->siswa->email }}</td>
                                    <td>{{ $rombel->siswa->no_hp }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-3 text-muted">Belum ada siswa di kelas ini.</div>
                @endif
            </div>
        </div>
    @endif
@endsection
