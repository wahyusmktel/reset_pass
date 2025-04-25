<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reset Akun Google')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .public-header {
            background: #6c63ff;
            color: #fff;
            padding: 1rem 0.5rem;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .public-footer {
            background: #f1f1f1;
            color: #888;
            text-align: center;
            padding: 1rem 0.5rem;
            margin-top: auto;
            font-size: 0.95rem;
        }

        .main-content {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 0;
        }

        @media (max-width: 600px) {
            .main-content {
                padding: 0 12px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <main class="main-content">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @stack('scripts')
</body>

</html>
