@extends('layouts.app') {{-- Sesuaikan layout kalau ada --}}
@section('title', 'Log Reset Google')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Log Reset Akun Google</h1>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>Email Lama</th>
                            <th>Email Baru</th>
                            <th>Password Baru</th>
                            <th>Tanggal Reset</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $index => $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>{{ $log->nama_pegawai }}</td>
                                <td>{{ $log->email_lama }}</td>
                                <td>{{ $log->email_baru }}</td>
                                <td>{{ $log->password_baru }}</td>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
