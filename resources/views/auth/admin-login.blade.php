<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Aplikasi Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Reset Password untuk SMK Telkom">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Custom CSS Variables */
            --primary-color: #b30000;
            --secondary-color: #800000;
            --accent-color: #f8f9fa;
            --text-light: #ffffff;
            --text-dark: #333333;
            --transition-speed: 0.3s;
            --card-border-radius: 15px;
            --btn-border-radius: 8px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--accent-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-dark);
            letter-spacing: 0.3px;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(150deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            border-radius: 0 16px 16px 0;
        }

        .sidebar-wrapper {
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: var(--btn-border-radius);
            margin-bottom: 8px;
            transition: all var(--transition-speed);
            font-weight: 500;
            padding: 10px 15px;
        }

        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            box-shadow: var(--shadow-sm);
            font-weight: 600;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--text-light);
            transform: translateX(3px);
            box-shadow: var(--shadow-sm);
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            box-shadow: var(--shadow-md);
            z-index: 1001;
            border-radius: 0 0 12px 12px;
            margin: 0 10px 10px 10px;
        }

        .navbar-brand {
            color: var(--text-light) !important;
            font-weight: 600;
        }

        .navbar .nav-link {
            color: var(--text-light) !important;
        }

        .navbar .fa-bell {
            font-size: 1.25rem;
        }

        /* Card and UI Elements */
        .card {
            border-radius: var(--card-border-radius);
            border: none;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-speed);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .btn {
            border-radius: var(--btn-border-radius);
            transition: all var(--transition-speed);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border-radius: var(--btn-border-radius);
            border: none;
            box-shadow: var(--shadow-md);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: var(--btn-border-radius);
            padding: 0.5rem 1rem;
            transition: all var(--transition-speed);
        }

        .dropdown-item:hover {
            background-color: rgba(179, 0, 0, 0.05);
        }

        /* Badge Styles */
        .badge {
            padding: 0.4em 0.6em;
            font-weight: 500;
            border-radius: 6px;
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 1rem 0;
            margin-top: auto;
            border-radius: 12px 12px 0 0;
            margin: 10px 10px 0 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                height: auto;
                position: relative;
            }

            .sidebar {
                width: 100%;
                height: auto;
                border-radius: 0 0 16px 16px;
            }

            .content-wrapper {
                margin-left: 0;
            }

            .navbar {
                margin: 0 0 10px 0;
                border-radius: 0 0 12px 12px;
            }

            .footer {
                margin: 10px 0 0 0;
                border-radius: 12px 12px 0 0;
            }
        }

        /* Table Styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-responsive {
            border-radius: var(--card-border-radius);
            overflow: hidden;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: var(--btn-border-radius);
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            transition: all var(--transition-speed);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(179, 0, 0, 0.3);
            box-shadow: 0 0 0 0.25rem rgba(179, 0, 0, 0.1);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="d-flex flex-column min-vh-100" style="background: linear-gradient(120deg, #b30000 0%, #800000 100%);">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow card-soft p-4 bg-white position-relative" style="border-radius: 24px;">
                    <div class="text-center mb-4">
                        <div style="width:64px;height:64px;margin:0 auto 12px auto;background:linear-gradient(135deg,#b30000,#800000);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(179,0,0,0.08);">
                            <i class="fa-solid fa-user-shield fa-2x text-white"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color:#b30000;">Login Admin</h3>
                        <p class="text-muted mb-0" style="font-size:1rem;">Akses Panel Reset Password</p>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-danger"></i></span>
                                <input type="email" name="email" class="form-control shadow-none" required autofocus placeholder="Masukan Email...">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-lock text-danger"></i></span>
                                <input type="password" name="password" class="form-control shadow-none" required placeholder="********">
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 btn-soft mt-2" style="font-size:1.1rem;">Masuk <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
