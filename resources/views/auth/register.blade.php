@extends('frontend.layouts.app')

@section('title', 'Register - Research Peptides')

@section('content')
<div class="container py-5" >
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- Glass Form Card -->
            <div class="glass-card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="scientific-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Create Account</h2>
                        <p class="text-muted mb-0">Join thousands of researchers worldwide</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- Name and Email Row -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-person me-2"></i>Full Name
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                           autocomplete="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Customer Type Selection -->
                        <div class="customer-type-section mt-4">
                            <label class="form-label">
                                <i class="bi bi-building me-2"></i>Customer Type
                            </label>
                            <div class="customer-type-options">
                                <div class="form-check customer-type-option">
                                    <input class="form-check-input" type="radio" name="customer_type" id="customer_type_retailer" value="retailer" checked>
                                    <label class="form-check-label" for="customer_type_retailer">
                                        <div class="option-content">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <strong>Retailer</strong>
                                                <small class="text-muted d-block">Individual researcher or small lab</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check customer-type-option">
                                    <input class="form-check-input" type="radio" name="customer_type" id="customer_type_wholesaler" value="wholesaler">
                                    <label class="form-check-label" for="customer_type_wholesaler">
                                        <div class="option-content">
                                            <i class="bi bi-building"></i>
                                            <div>
                                                <strong>Wholesaler</strong>
                                                <small class="text-muted d-block">Company or large organization</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Wholesaler Company Fields (Hidden by default) -->
                        <div class="wholesaler-fields" id="wholesalerFields" style="display: none;">
                            <div class="wholesaler-section-header">
                                <h6 class="text-primary mb-3">
                                    <i class="bi bi-building me-2"></i>Company Information
                                </h6>
                            </div>
                            
                            <!-- Company Name and Registration Number -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name" class="form-label">
                                            <i class="bi bi-building me-2"></i>Company Name
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="company_name" 
                                               name="company_name" 
                                               value="{{ old('company_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_registration" class="form-label">
                                            <i class="bi bi-file-earmark-text me-2"></i>Registration Number
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="company_registration" 
                                               name="company_registration" 
                                               value="{{ old('company_registration') }}"
                                               placeholder="e.g., VAT, Tax ID, etc.">
                                    </div>
                                </div>
                            </div>

                            <!-- Company Address -->
                            <div class="form-group">
                                <label for="company_address" class="form-label">
                                    <i class="bi bi-geo-alt me-2"></i>Company Address
                                </label>
                                <textarea class="form-control" 
                                          id="company_address" 
                                          name="company_address" 
                                          rows="3"
                                          placeholder="Full company address">{{ old('company_address') }}</textarea>
                            </div>

                            <!-- Company Contact and Website -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_phone" class="form-label">
                                            <i class="bi bi-telephone me-2"></i>Company Phone
                                        </label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="company_phone" 
                                               name="company_phone" 
                                               value="{{ old('company_phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_website" class="form-label">
                                            <i class="bi bi-globe me-2"></i>Company Website
                                        </label>
                                        <input type="url" 
                                               class="form-control" 
                                               id="company_website" 
                                               name="company_website" 
                                               value="{{ old('company_website') }}"
                                               placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>

                            <!-- Business Type and Industry -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_type" class="form-label">
                                            <i class="bi bi-briefcase me-2"></i>Business Type
                                        </label>
                                        <select class="form-control" id="business_type" name="business_type">
                                            <option value="">Select Business Type</option>
                                            <option value="pharmaceutical" {{ old('business_type') == 'pharmaceutical' ? 'selected' : '' }}>Pharmaceutical</option>
                                            <option value="biotechnology" {{ old('business_type') == 'biotechnology' ? 'selected' : '' }}>Biotechnology</option>
                                            <option value="research_institute" {{ old('business_type') == 'research_institute' ? 'selected' : '' }}>Research Institute</option>
                                            <option value="university" {{ old('business_type') == 'university' ? 'selected' : '' }}>University</option>
                                            <option value="hospital" {{ old('business_type') == 'hospital' ? 'selected' : '' }}>Hospital</option>
                                            <option value="laboratory" {{ old('business_type') == 'laboratory' ? 'selected' : '' }}>Laboratory</option>
                                            <option value="distributor" {{ old('business_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                            <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="industry" class="form-label">
                                            <i class="bi bi-diagram-3 me-2"></i>Industry
                                        </label>
                                        <select class="form-control" id="industry" name="industry">
                                            <option value="">Select Industry</option>
                                            <option value="healthcare" {{ old('industry') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                            <option value="life_sciences" {{ old('industry') == 'life_sciences' ? 'selected' : '' }}>Life Sciences</option>
                                            <option value="academic" {{ old('industry') == 'academic' ? 'selected' : '' }}>Academic</option>
                                            <option value="clinical_research" {{ old('industry') == 'clinical_research' ? 'selected' : '' }}>Clinical Research</option>
                                            <option value="drug_development" {{ old('industry') == 'drug_development' ? 'selected' : '' }}>Drug Development</option>
                                            <option value="biomedical" {{ old('industry') == 'biomedical' ? 'selected' : '' }}>Biomedical</option>
                                            <option value="other" {{ old('industry') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Expected Order Volume -->
                            <div class="form-group">
                                <label for="expected_volume" class="form-label">
                                    <i class="bi bi-graph-up me-2"></i>Expected Monthly Order Volume
                                </label>
                                <select class="form-control" id="expected_volume" name="expected_volume">
                                    <option value="">Select Expected Volume</option>
                                    <option value="small" {{ old('expected_volume') == 'small' ? 'selected' : '' }}>Small (1-10)</option>
                                    <option value="medium" {{ old('expected_volume') == 'medium' ? 'selected' : '' }}>Medium (11-50)</option>
                                    <option value="large" {{ old('expected_volume') == 'large' ? 'selected' : '' }}>Large (51-100)</option>
                                    <option value="enterprise" {{ old('expected_volume') == 'enterprise' ? 'selected' : '' }}>Enterprise (10+ units)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Password Row -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
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
                                               autocomplete="new-password">
                                        <button type="button" 
                                                class="password-toggle" 
                                                id="togglePassword">
                                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength mt-2" id="password-strength"></div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="form-label">
                                        <i class="bi bi-lock me-2"></i>Confirm Password
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password-confirm" 
                                               name="password_confirmation" 
                                               required 
                                               autocomplete="new-password">
                                        <button type="button" 
                                                class="password-toggle" 
                                                id="togglePasswordConfirm">
                                            <i class="bi bi-eye" id="togglePasswordConfirmIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="password-requirements mt-3">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-info-circle me-1"></i>Password Requirements
                            </h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="requirement-item" data-requirement="length">
                                        <i class="bi bi-circle text-muted"></i>
                                        <small class="text-muted">At least 8 characters</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="requirement-item" data-requirement="uppercase">
                                        <i class="bi bi-circle text-muted"></i>
                                        <small class="text-muted">One uppercase letter</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="requirement-item" data-requirement="number">
                                        <i class="bi bi-circle text-muted"></i>
                                        <small class="text-muted">One number</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="requirement-item" data-requirement="special">
                                        <i class="bi bi-circle text-muted"></i>
                                        <small class="text-muted">One special character</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="terms-section mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label text-muted" for="terms">
                                    I agree to the 
                                    <a href="#" class="text-decoration-none">
                                        <span class="text-primary fw-semibold">Terms of Service</span>
                                    </a> 
                                    and 
                                    <a href="#" class="text-decoration-none">
                                        <span class="text-primary fw-semibold">Privacy Policy</span>
                                    </a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-section mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-3" id="submitBtn">
                                <i class="bi bi-person-plus me-2"></i>Create Account
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

                    <!-- Login Link -->
                    <div class="login-link text-center">
                        <p class="text-muted mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    
    /* Customer Type Selection Styles */
    .customer-type-options {
        display: flex;
        gap: 1rem;
        margin-top: 0.5em;
    }
    
    .customer-type-option {
        flex: 1;
        margin: 0;
    }
    
    .customer-type-option .form-check-input {
        display: none;
    }
    
    .customer-type-option .form-check-label {
        display: block;
        padding: 1rem;
        background: rgba(255, 255, 255,0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(102, 126, 234,0.2);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .customer-type-option .form-check-input:checked + .form-check-label {
        background: rgba(102, 126, 234,0.1);
        border-color: rgba(102, 126, 234,0.4);
        box-shadow: 0 4px 15px rgba(102, 126, 234,0.2);
    }
    
    .option-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5em;
    }
    
    .option-content i {
        font-size: 1.5rem;
        color: #667ea;
    }
    
    .option-content strong {
        color: #495057;
        font-size: 0.9em;
    }
    
    .option-content small {
        font-size: 0.75em;
    }
    
    /* Wholesaler Fields Styles */
    .wholesaler-fields {
        background: rgba(248, 249, 250,0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(102, 126, 234,0.2);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .wholesaler-section-header h6 {
        color: #667ea;
        font-weight: 600;
        border-bottom: 1px solid rgba(102, 126, 234,0.2);
        padding-bottom: 0.5em;
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
    
    /* Password Requirements */
    .password-requirements {
        background: rgba(248, 249, 250,0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(102, 126, 234,0.2);
        border-radius: 12px;
        padding: 1.25rem;
    }
    
    .password-requirements h6 {
        color: #495057;
        font-weight: 500;
    }
    
    .requirement-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }
    
    .requirement-item small {
        color: #6c757d;
    }
    
    .requirement-item.valid {
        color: #198754;
    }
    
    .requirement-item.valid i {
        color: #198754;
    }
    
    .requirement-item.valid i::before {
        content: "\F26B";
    }
    
    .requirement-item.valid small {
        color: #198754;
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
    
    /* Login Link */
    .login-link p {
        color: #6c757d;
    }
    
    .login-link a {
        color: #667ea !important;
        font-weight: 600;
    }
    
    .login-link a:hover {
        color: #5a6fd8 !important;
    }
    
    /* Progress Bar */
    .progress {
        background: rgba(255, 255, 255,0.8);
        backdrop-filter: blur(5px);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 10px;
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

        .customer-type-options {
            flex-direction: column;
        }
        
        .wholesaler-fields {
            padding: 1rem;
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
    setupPasswordToggle('password-confirm', 'togglePasswordConfirmIcon');
    
    // Customer type selection
    document.addEventListener('DOMContentLoaded', function() {
        const retailerRadio = document.getElementById('customer_type_retailer');
        const wholesalerRadio = document.getElementById('customer_type_wholesaler');
        const wholesalerFields = document.getElementById('wholesalerFields');
        
        function toggleWholesalerFields() {
            if (wholesalerRadio.checked) {
                wholesalerFields.style.display = 'block';
                // Make wholesaler fields required
                const wholesalerInputs = wholesalerFields.querySelectorAll('input, select, textarea');
                wholesalerInputs.forEach(input => {
                    if (input.name !== 'company_website') { // Website is optional
                        input.required = true;
                    }
                });
            } else {
                wholesalerFields.style.display = 'none';
                // Remove required from wholesaler fields
                const wholesalerInputs = wholesalerFields.querySelectorAll('input, select, textarea');
                wholesalerInputs.forEach(input => {
                    input.required = false;
                });
            }
        }
        
        retailerRadio.addEventListener('change', toggleWholesalerFields);
        wholesalerRadio.addEventListener('change', toggleWholesalerFields);
        
        // Initialize on page load
        toggleWholesalerFields();
    });
    
    // Password strength and requirements checker
    document.getElementById('password').addEventListener('input', function() {
        const val = this.value;
        const strength = document.getElementById('password-strength');
        
        // Check requirements
        const requirements = {
            length: val.length >= 8,
            uppercase: /[A-Z]/.test(val),
            number: /[0-9]/.test(val),
            special: /[^A-Za-z0-9]/.test(val)
        };
        
        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const item = document.querySelector(`[data-requirement="${req}"]`);
            if (item) {
                if (requirements[req]) {
                    item.classList.add('valid');
                } else {
                    item.classList.remove('valid');
                }
            }
        });
        
        // Calculate strength
        const score = Object.values(requirements).filter(Boolean).length;
        let msg = '', color = '';
        
        switch(score) {
            case 0:
            case 1:
                msg = 'Very Weak'; color = 'danger'; break;
            case 2:
                msg = 'Weak'; color = 'warning'; break;
            case 3:
                msg = 'Good'; color = 'info'; break;
            case 4:
                msg = 'Strong'; color = 'success'; break;
        }
        
        if(val.length === 0) {
            strength.innerHTML = '';
        } else {
            strength.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-${color}" style="width: ${(score/4)*100}%"></div>
                    </div>
                    <small class="text-${color} fw-medium">${msg}</small>
                </div>
            `;
        }
    });
    
    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password-confirm').value;
        const terms = document.getElementById('terms').checked;
        const customerType = document.querySelector('input[name="customer_type"]:checked').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            showToast('Passwords do not match', 'danger');
            return;
        }
        
        if (!terms) {
            e.preventDefault();
            showToast('Please accept the terms and conditions', 'warning');
            return;
        }
        
        // Validate wholesaler fields if selected
        if (customerType === 'wholesaler') {
            const requiredFields = ['company_name', 'company_address', 'company_phone', 'business_type', 'industry', 'expected_volume'];
            const missingFields = [];
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (!field.value.trim()) {
                    missingFields.push(field.previousElementSibling.textContent.replace(/[^\w\s]/g, '').trim());
                }
            });
            
            if (missingFields.length > 0) {
                e.preventDefault();
                showToast(`Please fill in: ${missingFields.join(', ')}`, 'warning');
                return;
            }
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating Account...';
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