@extends('layouts.pegawai_app')

@section('title', 'Pengajuan Reset Password Pegawai')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e5e6 100%);">
                    <h3 class="text-center mb-0 py-3" style="color: #dc3545;">Pengajuan Reset Password</h3>
                </div>
                <div class="card-body p-5">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('public.pegawai.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="nip" class="form-label fw-bold" style="color: #6c757d;">NIP Pegawai</label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-light border-0" style="color: #dc3545;">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" name="nip" id="nip" class="form-control border-0 bg-light animate__animated animate__fadeIn"
                                    style="height: 58px; transition: all 0.3s ease;"
                                    placeholder="Cari NIP Pegawai..." required autocomplete="off">
                                <div id="nipAutocomplete" class="autocomplete-items" style="display: none; position: absolute; z-index: 99; width: calc(100% - 58px); left: 58px; top: 58px; max-height: 250px; overflow-y: auto; border-radius: 0 0 8px 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"></div>
                            </div>
                        </div>

                        <div id="detailPegawai" class="animate__animated animate__fadeIn" style="display:none;">
                            <div class="card bg-light border-0 rounded-4 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4 text-center" style="color: #dc3545;">Detail Pegawai</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Nama</div>
                                        <div class="col-md-8 fw-bold" id="nama_guru"></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-muted">Email</div>
                                        <div class="col-md-8 fw-bold" id="email_guru"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-muted">Jabatan</div>
                                        <div class="col-md-8 fw-bold" id="jabatan"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg btn-danger animate__animated animate__pulse animate__infinite animate__slower shadow-sm"
                                    style="background-color: #dc3545; border: none; border-radius: 12px; transition: all 0.3s ease;">
                                    <i class="fas fa-key me-2"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<script>
    const pegawaiData = @json(\App\Models\Pegawai::all()->keyBy('nip'));
    const nipInput = document.getElementById('nip');
    const autocompleteContainer = document.getElementById('nipAutocomplete');

    // Initialize autocomplete functionality
    nipInput.addEventListener('input', function() {
        const inputValue = this.value.toLowerCase();
        showAutocompleteResults(inputValue);
    });

    nipInput.addEventListener('focus', function() {
        if (this.value) {
            showAutocompleteResults(this.value.toLowerCase());
        }
    });

    // Close autocomplete list when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target !== nipInput && e.target !== autocompleteContainer) {
            autocompleteContainer.style.display = 'none';
        }
    });

    function showAutocompleteResults(inputValue) {
        // Clear previous results
        autocompleteContainer.innerHTML = '';
        autocompleteContainer.style.display = 'none';

        if (!inputValue) {
            showPegawaiData('');
            return;
        }

        // Filter pegawai data based on input
        const matches = Object.keys(pegawaiData).filter(nip =>
            nip.toLowerCase().includes(inputValue)
        );

        // Check if there's an exact match to show details immediately
        const exactMatch = matches.find(nip => nip.toLowerCase() === inputValue.toLowerCase());
        if (exactMatch) {
            showPegawaiData(exactMatch);
        } else if (matches.length === 1) {
            // If there's only one match, show its details
            showPegawaiData(matches[0]);
        } else if (matches.length > 1) {
            // If there are multiple matches but one starts with the input, prioritize it
            const startsWithMatch = matches.find(nip => nip.toLowerCase().startsWith(inputValue.toLowerCase()));
            if (startsWithMatch) {
                showPegawaiData(startsWithMatch);
            } else {
                // If no exact match but we have matches, show the first one's details
                showPegawaiData(matches[0]);
            }
        } else {
            // No matches found
            showPegawaiData('');
        }

        if (matches.length > 0) {
            autocompleteContainer.style.display = 'block';

            // Create a div for each matching item
            matches.forEach(nip => {
                const item = document.createElement('div');
                item.className = 'p-3 border-bottom autocomplete-item';
                item.style.cursor = 'pointer';
                item.style.backgroundColor = '#fff';
                item.style.transition = 'background-color 0.2s';
                item.innerHTML = `<strong>${nip}</strong>`;

                // Highlight the matching part
                item.innerHTML = item.innerHTML.replace(
                    new RegExp(inputValue, 'gi'),
                    match => `<span style="background-color: rgba(220, 53, 69, 0.2);">${match}</span>`
                );

                // Add hover effect
                item.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });

                item.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '#fff';
                });

                // Set the input value and show pegawai data when clicked
                item.addEventListener('click', function() {
                    nipInput.value = nip;
                    autocompleteContainer.style.display = 'none';
                    showPegawaiData(nip);
                });

                autocompleteContainer.appendChild(item);
            });
        }
    }

    function showPegawaiData(nip) {
        const detailElement = document.getElementById('detailPegawai');

        if (nip && pegawaiData[nip]) {
            const data = pegawaiData[nip];
            document.getElementById('nama_guru').textContent = data.nama_guru;
            document.getElementById('email_guru').textContent = maskEmail(data.email_guru);
            document.getElementById('jabatan').textContent = data.jabatan;

            // Hide first, then show with animation
            detailElement.style.display = 'none';
            setTimeout(() => {
                detailElement.style.display = 'block';
                detailElement.classList.remove('animate__fadeIn');
                void detailElement.offsetWidth; // Trigger reflow
                detailElement.classList.add('animate__fadeIn');
            }, 150);
        } else {
            detailElement.classList.remove('animate__fadeIn');
            detailElement.classList.add('animate__fadeOut');

            setTimeout(() => {
                detailElement.style.display = 'none';
                detailElement.classList.remove('animate__fadeOut');
            }, 500);
        }
    }

    function maskEmail(email) {
        const [name, domain] = email.split('@');
        const maskedName = name.length <= 2 ? name[0] + '*' : name[0] + '*'.repeat(name.length - 2) + name[name.length - 1];
        return maskedName + '@' + domain;
    }

    // Add hover effect to input
    nipInput.addEventListener('mouseover', function() {
        this.style.boxShadow = '0 0 15px rgba(220, 53, 69, 0.2)';
    });

    nipInput.addEventListener('mouseout', function() {
        this.style.boxShadow = 'none';
    });
</script>
@endsection
