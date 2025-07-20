@extends('frontend.layouts.app')

@section('title', 'Login - Research Peptides')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- Glass Form Card -->
            <div class="glass-card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="scientific-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Welcome Back</h2>
                        <p class="text-muted mb-0">Sign in to your research peptide account</p>
                    </div>
                    
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password" 
                                       name="password" 
                                       required
                                       autocomplete="current-password">
                                <button type="button" 
                                        class="password-toggle" 
                                        id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    <i class="bi bi-check2-square me-1"></i>
                                    Remember me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    <small class="text-primary fw-semibold">
                                        <i class="bi bi-question-circle me-1"></i>
                                        Forgot password?
                                    </small>
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary w-100 py-3" id="submitBtn">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="divider-section text-center my-4">
                        <div class="position-relative">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">or</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="register-link text-center">
                        <p class="text-muted mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                                Sign up here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(env('APP_ENV') == 'local')
    <div class="row">
        <div class="col-lg-6 mx-auto mt-5">
            <div class="glass-card">
                @php
                    $users = \App\Models\User::all();
                @endphp
                <div class="card-body">
                 <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{  $user->role_id == 2 ? ($user->is_wholesaler ? 'Wholesaler' : 'Retailer') : 'Admin' }}</td>
                                <td>{{ $user->current_level }}</td>
                                <td>
                                    <a href="{{ route('login.as', $user->id) }}" class="btn btn-primary">Login </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 </table>
                </div>
            </div>  
        </div>
    </div>
    @endif

<!-- Authentic Glass Design Styles -->
<style>
    body {
        background: linear-gradient(135deg, #667ea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20 20, rgba(255,255,255,0.1) 1x, transparent 1px),
            radial-gradient(circle at 80 80, rgba(255,255,255,0.1) 1x, transparent 1px);
        background-size: 60px 60px;
        z-index: -1;
    }
    
    /* Authentic Glass Card */
    .glass-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255,0.3);
        border-radius: 20px;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0,0.1),
            inset 0px 0px 0px 0px rgba(255, 255, 255,0.05);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3));
    }
    
    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.15),
            inset 0px 0px 0px 0px rgba(255, 255, 255,0.08);
    }
    
    .glass-card .card-body {
        padding: 2.5rem;
        position: relative;
        z-index: 1;
    }
    
    .scientific-icon {
        width: 70px;
        height: 70px;
        background: rgba(102, 126, 234,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(102, 126, 234,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.75rem;
        color: #667ea;
        box-shadow: 0 4px 15px rgba(0, 0, 0,0.1);
    }
    
    /* Form Styles */
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        background: rgba(255, 255, 255,0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(102, 126, 234,0.2);
        border-radius: 12px;
        padding: 0.875rem;
        color: #495057;
        transition: all 0.3s ease;
        font-weight: 400;
    }
    
    .form-control::placeholder {
        color: #6c757d;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255,0.9);
        border-color: rgba(102, 126, 234,0.4);
        box-shadow: 0 0 0 0.2rem rgba(121, 126, 234,0.25);
        color: #495057;
    }
    
    .form-control:focus::placeholder {
        color: #6c757d;
    }
    
    /* Password Input Wrapper */
    .password-input-wrapper {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 0.25rem;
    }
    
    .password-toggle:hover {
        color: #667ea;
    }
    
    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #667ea 0%, #764ba2 100%);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 12px;
        font-weight: 500;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234,0.4);
        color: white;
    }
    
    .btn-primary:disabled {
        opacity: 0.6;
        transform: none;
    }
    
    /* Form Check */
    .form-check-input {
        background: rgba(255, 255, 255,0.1);
        border: 1px solid rgba(102, 126, 234,0.2);
        backdrop-filter: blur(5px);
    }
    
    .form-check-input:checked {
        background-color: #667ea;
        border-color: #667ea;
    }
    
    .form-check-input:focus {
        border-color: #667ea;
        box-shadow: 0 0 0 0.2rem rgba(121, 126, 234,0.25);
    }
    
    .form-check-label {
        color: #495057;
    }
    
    /* Divider */
    .divider-section hr {
        border-color: #dee2e6;
    }
    
    .divider-section span {
        background: rgba(255, 255, 255,0.9);
        backdrop-filter: blur(10px);
        color: #6c757d;
    }
    
    /* Register Link */
    .register-link p {
        color: #6c757d;
    }
    
    .register-link a {
        color: #667ea !important;
        font-weight: 600;
    }
    
    .register-link a:hover {
        color: #5a6fd8 !important;
    }
    
    /* Alert Styles */
    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #198754;
    }
    
    /* Text Colors */
    h2 {
        color: #495057;
    }
    
    p.text-muted {
        color: #6c757d !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .glass-card .card-body {
            padding: 2rem;
        }
        
        .scientific-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }
</style>

@push('scripts')
<script>
    // Password toggle functionality
    function setupPasswordToggle(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        icon.addEventListener('click', function() {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }
    
    setupPasswordToggle('password', 'togglePasswordIcon');
    
    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            showToast('Please fill in all required fields', 'warning');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Signing In...';
    });
    
    // Toast notification function
    function showToast(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alert.style.zIndex = '9999';
        alert.style.borderRadius = '12px';
        alert.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        alert.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>
@endpush
@endsection
