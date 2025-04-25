<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password | SMK Telkom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:
                linear-gradient(rgba(255, 255, 255, 0.9), rgba(250, 250, 250, 0.9)),
                #001100;
            position: relative;
            overflow: auto;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(0deg,
                    rgba(255, 0, 0, 0.05) 0px,
                    rgba(255, 255, 255, 0.66) 1px,
                    transparent 1px,
                    transparent 3px);
            pointer-events: none;
            animation: scroll 20s linear infinite;
        }

        @keyframes scroll {
            100% {
                background-position: 0 100px;
            }
        }

        .code-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
            pointer-events: none;
        }

        .code-line {
            color: rgb(51, 51, 51);
            font-family: 'Courier New', monospace;
            font-size: 14px;
            white-space: pre;
            text-shadow: 0 0 10pxrgb(25, 25, 25), 0 0 20pxrgb(25, 25, 25);
            position: absolute;
            animation: fall 15s linear infinite, glow 2s ease-in-out infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100vh);
            }
        }

        .card-soft {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-soft:hover {
            transform: translateY(-4px) rotate(1deg);
            box-shadow: 0 12px 32px rgba(179, 0, 0, 0.2);
            background: linear-gradient(45deg, #ffffff 0%, #fff5f5 100%);
        }

        .bg-main {
            background-color: #b30000;
            color: white;
        }

        .btn-soft {
            background-color: #b30000;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            color: white;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-soft:hover {
            background: linear-gradient(45deg, #a00000, #c00000);
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 4px 15px rgba(160, 0, 0, 0.3);
            color: white;
        }
    </style>
</head>

<body>
    <div class="code-overlay">
        <div class="code-line" style="left: 50%; animation-delay: 0s; writing-mode: vertical-rl;">SMK TELKOM LAMPUNG</div>
    </div>
    <style>
        .code-line {
            color: rgb(51, 51, 51);
            font-family: 'Courier New', monospace;
            font-size: 14px;
            white-space: pre;
            text-shadow: 0 0 10px rgb(25, 25, 25), 0 0 20px rgb(25, 25, 25);
            position: absolute;
            animation: fall 15s linear infinite, glow 2s ease-in-out infinite, blink 1s step-end infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
    </style>

    <div class="container py-5" style="position:relative;z-index:1">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-danger">Permintaan Reset Password</h1>
            <p class="text-secondary fs-5">Layanan reset password untuk akun internal SMK Telkom Lampung</p>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- Reset Akun Google --}}
            <div class="col-md-4">
                <div class="card card-soft p-4 h-100 text-center">
                    <h4 class="fw-bold text-danger mb-3">Reset Akun Google</h4>
                    <p class="text-muted mb-4">Layanan reset akun email sekolah @smktelkom.sch.id</p>
                    <a href="{{ route('pengajuan-google.create') }}" class="btn btn-soft">Ajukan Reset</a>
                </div>
            </div>

            {{-- Reset Akun MyLMS --}}
            <div class="col-md-4">
                <div class="card card-soft p-4 h-100 text-center">
                    <h4 class="fw-bold text-danger mb-3">Reset Akun MyLMS</h4>
                    <p class="text-muted mb-4">Reset password untuk sistem e-learning MyLMS SMK Telkom</p>
                    <a href="{{ route('pengajuan-mylms.create') }}" class="btn btn-soft">Ajukan Reset</a>
                </div>
            </div>

            {{-- Reset Akun iGracias --}}
            <div class="col-md-4">
                <div class="card card-soft p-4 h-100 text-center">
                    <h4 class="fw-bold text-danger mb-3">Reset Akun iGracias</h4>
                    <p class="text-muted mb-4">Reset akun akademik iGracias Telkom Schools untuk siswa aktif</p>
                    <a href="{{ route('pengajuan-igracias.create') }}" class="btn btn-soft">Ajukan Reset</a>
                </div>
            </div>
        </div>

        <!-- Tambahan opsi untuk layanan pegawai -->
        <div class="mt-5 text-center">
            <h3 class="fw-bold mb-4">Layanan Pegawai</h3>
            <a href="{{ route('landing-pegawai') }}" class="btn btn-soft">
                <i class="fas fa-user-tie me-2"></i>Reset Akun Pegawai
            </a>
        </div>
    </div>
    <div id="fingerprint-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:1000;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
                <circle cx="50" cy="50" r="40" stroke="white" stroke-width="3" fill="none" />
                <path d="M50,10 a40,40 0 1,0 0,80 a40,40 0 1,0 0,-80" stroke="white" stroke-width="3" fill="none" />
            </svg>
        </div>
        <script>
            const codeLines = [
                'def hello_world():',
                '    print("Hello, World!")',
                'hello_world()',
                'def add(a, b):',
                '    return a + b',
                'print(add(5, 3))',
                'def subtract(a, b):',
                '    return a - b',
                'print(subtract(10, 4))',
                'def multiply(a, b):',
                '    return a * b',
                'print(multiply(6, 7))',
                'def divide(a, b):',
                '    return a / b',
                'print(divide(8, 2))',
                'def greet(name):',
                '    print(f"Hello, {name}!")',
                'greet("Alice")',
                'def square(x):',
                '    return x * x',
                'print(square(9))'
            ];

            function createCodeLine(line, delay) {
                const overlay = document.querySelector('.code-overlay');
                const codeLine = document.createElement('div');
                codeLine.className = 'code-line';
                codeLine.style.left = `${Math.random() * 90 + 5}%`;
                codeLine.style.animationDelay = `-${Math.random() * 20}s`;
                codeLine.textContent = line;
                overlay.appendChild(codeLine);

                setTimeout(() => {
                    overlay.removeChild(codeLine);
                }, 15000);
            }

            let delay = 0;
            codeLines.forEach(line => {
                setTimeout(() => createCodeLine(line, delay), delay * 1000);
                delay += 1;
            });

            setInterval(() => {
                delay = 0;
                codeLines.forEach(line => {
                    setTimeout(() => createCodeLine(line, delay), delay * 1000);
                    delay += 1;
                });
            }, 5000);
            document.querySelectorAll('.btn-soft').forEach(button => {
                button.addEventListener('click', function() {
                    const overlay = document.getElementById('fingerprint-overlay');
                    overlay.innerHTML =
                        '<div style="color: lime; font-family: monospace; text-align: center; margin-top: 20%;">Access Granted<br>System Breached</div>';
                    overlay.style.display = 'block';
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 3000);
                });
            });
        </script>
