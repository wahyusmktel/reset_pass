<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Layanan Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #b31217 0%, #7b1f23 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            background: linear-gradient(90deg, #b31217 0%, #7b1f23 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

        .section-title {
            color: #fff;
            margin-bottom: 30px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="section-title">Layanan Reset Akun Pegawai SMK Telkom Lampung</h1>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fab fa-google fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun Google Workspace</h5>
                        <p class="card-text">Reset password email Google Workspace Anda untuk akses layanan sekolah.</p>
                        <a href="#" class="btn btn-primary">Reset Akun Google</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-building fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun Dapodik</h5>
                        <p class="card-text">Permintaan reset akun Dapodik untuk keperluan administrasi sekolah.</p>
                        <a href="#" class="btn btn-primary">Reset Akun Dapodik</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun Belajar ID</h5>
                        <p class="card-text">Layanan reset akun Belajar.id untuk akses platform pembelajaran nasional.
                        </p>
                        <a href="#" class="btn btn-primary">Reset Akun Belajar ID</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-laptop-code fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun MyLMS</h5>
                        <p class="card-text">Reset password akun MyLMS untuk mendukung kegiatan e-learning Anda.</p>
                        <a href="#" class="btn btn-primary">Reset Akun MyLMS</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>

</html>
