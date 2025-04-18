@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="mb-4">Dashboard Admin</h2>

    {{-- Statistik Ringkas --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Reset Google</h5>
                    <h2 class="text-primary">{{ $jumlahGoogle }}</h2>
                    <small class="text-muted">Total Pengajuan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Reset MyLMS</h5>
                    <h2 class="text-success">{{ $jumlahMylms }}</h2>
                    <small class="text-muted">Total Pengajuan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Reset iGracias</h5>
                    <h2 class="text-danger">{{ $jumlahIgracias }}</h2>
                    <small class="text-muted">Total Pengajuan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-left border-4 border-warning">
                <div class="card-body text-center">
                    <h6 class="text-muted">Belum Respon Google</h6>
                    <h3 class="text-warning">{{ $belumResponGoogle }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left border-4 border-warning">
                <div class="card-body text-center">
                    <h6 class="text-muted">Belum Respon MyLMS</h6>
                    <h3 class="text-warning">{{ $belumResponMylms }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left border-4 border-warning">
                <div class="card-body text-center">
                    <h6 class="text-muted">Belum Respon iGracias</h6>
                    <h3 class="text-warning">{{ $belumResponIgracias }}</h3>
                </div>
            </div>
        </div>
    </div>


    {{-- Grafik Pengajuan --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-4">Statistik Pengajuan 30 Hari Terakhir</h5>
            <canvas id="grafikPengajuan" height="120"></canvas>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-5">
        <div class="card-body">
            <h5 class="card-title mb-4">Total Reset Akun per Kelas</h5>
            <canvas id="grafikPerKelasTotal" height="120"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('grafikPengajuan').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($grafik->pluck('tanggal')) !!},
                    datasets: [{
                            label: 'Google',
                            data: {!! json_encode($grafik->pluck('google')) !!},
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'MyLMS',
                            data: {!! json_encode($grafik->pluck('mylms')) !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'iGracias',
                            data: {!! json_encode($grafik->pluck('igracias')) !!},
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <script>
            const ctxTotalKelas = document.getElementById('grafikPerKelasTotal').getContext('2d');
            const chartTotalKelas = new Chart(ctxTotalKelas, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kelasData->pluck('nama_kelas')) !!},
                    datasets: [{
                            label: 'Google',
                            data: {!! json_encode($kelasData->pluck('pengajuan_reset_google_count')) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'MyLMS',
                            data: {!! json_encode($kelasData->pluck('pengajuan_reset_mylms_count')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'iGracias',
                            data: {!! json_encode($kelasData->pluck('pengajuan_reset_igracias_count')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
