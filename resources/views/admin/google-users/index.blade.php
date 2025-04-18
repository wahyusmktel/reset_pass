@extends('layouts.app')

@section('title', 'Daftar User Google Workspace')

@section('content')
    <h1 class="mb-4">Daftar User Google Workspace</h1>

    <div class="mb-3">
        <a href="{{ route('admin.google.users', ['refresh' => 1]) }}" class="btn btn-sm btn-outline-danger">
            🔄 Refresh Cache User
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Pencarian --}}
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" class="form-control" value="{{ request('q') }}"
                placeholder="Cari nama atau email...">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100">Cari</button>
        </div>
    </form>

    {{-- Tabel User --}}
    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Email</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Login Terakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse ($users as $user)
                <tr>
                    <td>{{ $user->getPrimaryEmail() }}</td>
                    <td>{{ $user->getName()->getFullName() }}</td>
                    <td>
                        <span class="badge {{ $user->getSuspended() ? 'bg-danger' : 'bg-success' }}">
                            {{ $user->getSuspended() ? 'Suspended' : 'Aktif' }}
                        </span>
                    </td>
                    <td>{{ $user->getLastLoginTime() ? \Carbon\Carbon::parse($user->getLastLoginTime())->format('d M Y H:i') : '-' }}
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary disabled">Detail</a>
                        <a href="#" class="btn btn-sm btn-warning disabled">Reset</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse --}}
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>
                        <span class="badge {{ $user['suspended'] ? 'bg-danger' : 'bg-success' }}">
                            {{ $user['suspended'] ? 'Suspended' : 'Aktif' }}
                        </span>
                    </td>
                    <td>
                        {{ $user['last_login'] ? \Carbon\Carbon::parse($user['last_login'])->format('d M Y H:i') : '-' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.google-users.show', $user['id']) }}"
                            class="btn btn-sm btn-primary">Detail</a>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#resetModal{{ $user['id'] }}">
                            Reset
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
            @foreach ($users as $user)
                {{-- Table rows... --}}

                <!-- Modal Reset Password -->
                <div class="modal fade" id="resetModal{{ $user['id'] }}" tabindex="-1"
                    aria-labelledby="resetModalLabel{{ $user['id'] }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.google-users.reset', $user['id']) }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reset Password: {{ $user['email'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Password Baru</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="password"
                                                id="passwordInput{{ $user['id'] }}" required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="generatePassword('{{ $user['id'] }}')">Generate</button>
                                            <button type="button" class="btn btn-outline-success"
                                                onclick="copyToClipboard('passwordInput{{ $user['id'] }}')">Copy</button>
                                        </div>
                                        <div class="form-text">Anda bisa mengisi manual atau klik "Generate" untuk membuat
                                            otomatis.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Reset Password</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    {{-- Paginasi Manual --}}
    @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $users->links() }}
    @endif

    @push('scripts')
        <script>
            function generatePassword(id) {
                const pass = Math.random().toString(36).slice(-8); // 8 digit random
                document.getElementById('passwordInput' + id).value = pass;
            }

            function copyToClipboard(inputId) {
                const input = document.getElementById(inputId);
                input.select();
                input.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }
        </script>
    @endpush


@endsection
