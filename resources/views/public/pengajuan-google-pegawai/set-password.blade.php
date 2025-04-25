@extends('layouts.pegawai_app')

@section('title', 'Setel Ulang Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeIn">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e5e6 100%);">
                    <h3 class="text-center mb-0 py-3" style="color: #dc3545;">Setel Ulang Password</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pegawai.setPassword.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4 password-field">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" id="password" class="form-control form-control-lg border-end-0 @error('password') is-invalid @enderror" required>
                                <span class="input-group-text bg-transparent border-start-0 password-toggle" onclick="togglePassword('password')">
                                    <i class="bi bi-eye-slash" id="password-icon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4 password-field">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg border-end-0 @error('password_confirmation') is-invalid @enderror" required>
                                <span class="input-group-text bg-transparent border-start-0 password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye-slash" id="password_confirmation-icon"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="button" class="btn btn-outline-secondary mb-3" onclick="generatePassword()">
                                <i class="bi bi-shuffle me-2"></i>Generate Password Acak
                            </button>
                            <button type="submit" class="btn btn-lg btn-primary w-100 reset-btn">
                                <i class="bi bi-check2-circle me-2"></i>Reset Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .form-control {
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        border-color: #dc3545;
    }
    
    .password-field {
        position: relative;
    }
    
    .password-toggle {
        cursor: pointer;
        border-radius: 0 8px 8px 0;
    }
    
    .password-toggle:hover {
        background-color: #f8f9fa;
    }
    
    .reset-btn {
        background: linear-gradient(45deg, #dc3545, #b02a37);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(220, 53, 69, 0.2);
    }
    
    .reset-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(220, 53, 69, 0.3);
        background: linear-gradient(45deg, #c82333, #a01e2c);
    }
    
    .input-group-merge .form-control:not(:last-child) {
        border-right: 0;
    }
    
    .input-group-merge .input-group-text {
        border-left: 0;
    }
    
    /* Animation for form elements */
    .form-control, .btn {
        animation: fadeInUp 0.5s;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const passwordIcon = document.getElementById(fieldId + '-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('bi-eye-slash');
            passwordIcon.classList.add('bi-eye');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('bi-eye');
            passwordIcon.classList.add('bi-eye-slash');
        }
    }
    
    // Generate random password
    function generatePassword() {
        // Generate a more complex password with letters, numbers and special characters
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        let password = '';
        
        // Ensure at least 8 characters
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        // Set both fields to the same password
        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
        
        // Show password temporarily
        document.getElementById('password').type = 'text';
        document.getElementById('password-icon').classList.remove('bi-eye-slash');
        document.getElementById('password-icon').classList.add('bi-eye');
        
        document.getElementById('password_confirmation').type = 'text';
        document.getElementById('password_confirmation-icon').classList.remove('bi-eye-slash');
        document.getElementById('password_confirmation-icon').classList.add('bi-eye');
        
        // Create a toast notification
        const toastContainer = document.createElement('div');
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        
        const toast = document.createElement('div');
        toast.className = 'toast show animate__animated animate__fadeInRight';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Password Generated</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Password acak telah dibuat dan diisi otomatis.
            </div>
        `;
        
        toastContainer.appendChild(toast);
        document.body.appendChild(toastContainer);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('animate__fadeInRight');
            toast.classList.add('animate__fadeOutRight');
            setTimeout(() => {
                document.body.removeChild(toastContainer);
            }, 500);
        }, 3000);
    }
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
            
            // Check if passwords match
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            
            if (password !== confirmation) {
                event.preventDefault();
                const confirmField = document.getElementById('password_confirmation');
                confirmField.setCustomValidity('Passwords do not match');
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = 'Password tidak cocok dengan konfirmasi';
                
                // Remove any existing error message first
                const existingError = confirmField.parentNode.parentNode.querySelector('.invalid-feedback');
                if (existingError) {
                    existingError.remove();
                }
                
                confirmField.parentNode.parentNode.appendChild(errorDiv);
            }
        });
    });
</script>
@endpush
