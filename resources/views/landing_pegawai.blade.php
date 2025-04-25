<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Layanan Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #ff2d20;
            --primary-glow: rgba(255, 45, 32, 0.5);
            --primary-dark: #b31217;
            --dark-bg: #121212;
            --card-bg: #1e1e1e;
            --card-border: #2d2d2d;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
        }

        body {
            background-color: var(--dark-bg);
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255, 45, 32, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 75% 75%, rgba(255, 45, 32, 0.05) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: linear-gradient(45deg, transparent 49%, rgba(255, 45, 32, 0.05) 50%, transparent 51%);
            background-size: 20px 20px;
            z-index: 0;
            opacity: 0.3;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -150%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, transparent, transparent, var(--primary-glow));
            animation: rotate 4s linear infinite;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(255, 45, 32, 0.2);
        }

        .card:hover::before {
            opacity: 1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .card-body {
            position: relative;
            z-index: 2;
            background-color: var(--card-bg);
            border-radius: 0.8rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        @media (max-width: 768px) {
            .fa-3x {
                margin-bottom: 1rem;
                display: block;
            }
        }

        .btn-primary {
            background-color: #f5f5f5;
            color: #333;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #ff2d20, #b31217);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 45, 32, 0.3);
            transform: translateY(-2px);
        }

        .card-title {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .card-text {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            color: var(--text-primary);
            margin-bottom: 40px;
            font-weight: bold;
            text-align: center;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary) 0%, transparent 100%);
            bottom: -10px;
            left: 25%;
            border-radius: 3px;
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
                        <a href="/reset-google-pegawai" class="btn btn-primary">Reset Akun Google</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-building fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun Dapodik</h5>
                        <p class="card-text">Permintaan reset akun Dapodik untuk keperluan administrasi sekolah.</p>
                        <a href="#" class="btn btn-primary">Cooming Soon</a>
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
                        <a href="#" class="btn btn-primary">Cooming Soon</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-laptop-code fa-3x mb-3 text-danger"></i>
                        <h5 class="card-title">Reset Akun MyLMS</h5>
                        <p class="card-text">Reset password akun MyLMS untuk mendukung kegiatan e-learning Anda.</p>
                        <a href="#" class="btn btn-primary">Cooming Soon</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>

</html>
