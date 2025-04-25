<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Reset Password Pegawai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Reset Password untuk Pegawai SMK Telkom">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Custom CSS Variables */
            --primary-color: #dc3545;
            --secondary-color: #b02a37;
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
            background-color: rgba(220, 53, 69, 0.05);
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
            border-color: rgba(220, 53, 69, 0.3);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
        }

        /* Animation classes */
        .animate__animated {
            animation-duration: 0.5s;
        }

        .animate__slower {
            animation-duration: 3s;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="d-flex flex-column min-vh-100">
    {{-- Main Content --}}
    <div class="flex-grow-1 content-wrapper">
        {{-- Navbar --}}


        {{-- Main content --}}
        <main class="p-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')
</body>

</html>
