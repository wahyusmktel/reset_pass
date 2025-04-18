@extends('layouts.app')

@section('title', 'Mapping Siswa Lokal dengan Google Workspace')

@section('content')
    <h1 class="mb-4">Mapping Siswa Lokal dengan Google Workspace</h1>

    <form method="POST" action="{{ route('admin.mapping-siswa.store') }}">
        @csrf
        <table class="table table-bordered bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Lokal</th>
                    <th>Nama Google</th>
                    <th>Email Google</th>
                    <th>Pilih</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse ($results as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['siswa']->nama }}</td>
                        <td>{{ $item['google']['name'] ?? '-' }}</td>
                        <td>{{ $item['google']['email'] ?? '-' }}</td>
                        <td>
                            @if ($item['google'])
                                <input type="checkbox" name="mapping[{{ $item['siswa']->id }}]"
                                    value="{{ $item['google']['email'] }}">
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data untuk dicocokkan.</td>
                    </tr>
                @endforelse --}}

                @forelse ($results as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['siswa']->nama }}</td>
                        <td>
                            @if ($item['google'])
                                {{ $item['google']['name'] }}
                            @else
                                <select class="form-select select-user" data-target="#mappingInput{{ $item['siswa']->id }}">
                                    <option value="">-- Pilih Google User --</option>
                                    @foreach ($googleUsers as $google)
                                        <option value="{{ $google['id'] }}" data-email="{{ $google['email'] }}">
                                            {{ $google['name'] }} ({{ $google['email'] }})
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>{{ $item['google']['email'] ?? '-' }}</td>
                        <td>
                            @if ($item['google'])
                                <input type="checkbox" name="mapping[{{ $item['siswa']->id }}]"
                                    value="{{ $item['google']['email'] }}">
                            @else
                                <input type="hidden" id="mappingInput{{ $item['siswa']->id }}"
                                    name="mapping[{{ $item['siswa']->id }}]">
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data untuk dicocokkan.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Update Email Terpilih</button>
    </form>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('.select-user').select2({
                    width: '100%',
                    placeholder: 'Pilih akun Google...'
                });

                // Sync value email ke input hidden saat select berubah
                $('.select-user').on('change', function() {
                    const selectedOption = $(this).find(':selected');
                    const email = selectedOption.data('email');
                    const inputTarget = $(this).data('target');
                    $(inputTarget).val(email);
                });
            });
        </script>
    @endpush

@endsection
