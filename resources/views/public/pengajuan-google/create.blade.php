@extends('public.layouts.public')

@section('title', 'Pengajuan Reset Akun Google')

@section('content')
    <style>
        /* Hapus style body agar tidak override layout utama */
        /* body {
                                                                                                                                                                                                                                                                                    min-height: 100vh;
                                                                                                                                                                                                                                                                                    margin: 0;
                                                                                                                                                                                                                                                                                    padding: 0;
                                                                                                                                                                                                                                                                                    background: linear-gradient(135deg, #b31217 0%, #7b1f23 100%);
                                                                                                                                                                                                                                                                                    display: flex;
                                                                                                                                                                                                                                                                                    align-items: center;
                                                                                                                                                                                                                                                                                    justify-content: center;
                                                                                                                                                                                                                                                                                    animation: bgfade 2s ease;
                                                                                                                                                                                                                                                                                } */
        @keyframes bgfade {
            from {
                filter: brightness(0.7);
            }

            to {
                filter: brightness(1);
            }
        }

        .reset-card-anim {
            max-width: 640px;
            width: 100%;
            border: none;
            background: #fff;
            box-shadow: 0 8px 32px rgba(123, 31, 35, 0.15);
            border-radius: 2rem;
            padding: 2.5rem 2.5rem;
            margin: 40px auto;
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            animation: cardin 0.8s cubic-bezier(.68, -0.55, .27, 1.55) 0.2s forwards;
        }

        @keyframes cardin {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .btn-primary {
            background: linear-gradient(90deg, #b31217 0%, #7b1f23 100%);
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px rgba(179, 18, 23, 0.15);
            background: linear-gradient(90deg, #7b1f23 0%, #b31217 100%);
        }

        .btn-link {
            color: #b31217 !important;
            transition: color 0.2s;
        }

        .btn-link:hover {
            color: #7b1f23 !important;
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .reset-card-anim {
                max-width: 98vw;
                padding: 35px;
            }
        }

        @media (max-width: 600px) {
            .reset-card-anim {
                padding: 35px;
                max-width: 100vw;
            }
        }
    </style>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container {
                width: 100% !important;
            }

            .select2-selection--single {
                height: calc(2.25rem + 2px);
                /* Match Bootstrap form-control height */
            }
        </style>
    @endpush
    <div class="reset-card-anim">
        <div class="text-center mb-4">
            <i class="fab fa-google me-2" style="font-size: 56px; color: #db4437; margin-bottom: 8px;"></i>
            <h2 class="fw-bold mb-1" style="font-size: 1.7rem; color: #7b1f23;">Form Pengajuan Reset Akun Google</h2>
            <p class="text-muted" style="font-size: 1.05rem;">Silakan isi data berikut untuk mengajukan reset akun Google
                sekolah Anda.</p>
        </div>
        <a href="{{ route('landing') }}" class="btn btn-link text-decoration-none px-0 mb-3">
            ← Kembali
        </a>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('pengajuan-google.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="siswa_id" class="form-label fw-semibold">Nama Siswa</label>
                <select id="siswa_id" name="siswa_id" class="form-select rounded-3" required></select>
                @error('siswa_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label fw-semibold">Nomor HP Aktif</label>
                <input type="text" name="no_hp" class="form-control rounded-3 @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp') }}" required>
                @error('no_hp')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Sekolah</label>
                <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label fw-semibold">Alasan Reset</label>
                <textarea name="keterangan" class="form-control rounded-3 @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary w-100">Kirim Pengajuan</button>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#siswa_id').select2({
            theme: 'classic',
            placeholder: '-- Cari nama atau NIS --',
            minimumInputLength: 2,
            language: {
                inputTooShort: function() {
                    return "Ketikan nama atau nis anda...";
                },
                searching: function() {
                    return "Sedang mencari data...";
                },
                noResults: function() {
                    return "Data tidak ditemukan";
                }
            },
            ajax: {
                url: '{{ route('ajax.siswa') }}',
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        // 👇 Ini bagian untuk preset value jika validation gagal
        @if (old('siswa_id'))
            $.ajax({
                type: 'GET',
                url: '{{ route('ajax.siswa') }}',
                data: {
                    q: ''
                },
                success: function(data) {
                    let selected = data.find(d => d.id === '{{ old('siswa_id') }}');
                    if (selected) {
                        let option = new Option(selected.text, selected.id, true, true);
                        $('#siswa_id').append(option).trigger('change');
                    }
                }
            });
        @endif
    </script>
@endpush
