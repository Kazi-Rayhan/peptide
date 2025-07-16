@php
    use Datlechin\FilamentMenuBuilder\Models\Menu;
    $menu = Menu::location('main');
    $mobileMenu = Menu::location('mobile');
    $quickLinks = Menu::location('quick_links');
    $customerService = Menu::location('customer_service');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', setting('seo.meta_title', config('app.name')))</title>
    <link rel="icon" href="{{ Storage::url(setting('store.favicon', 'favicon.ico')) }}" type="image/x-icon">
    <meta name="description" content="@yield('meta_description', setting('seo.meta_description'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('seo.meta_keywords'))">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1e40af;
            --primary-light: #3b82f6;
            --primary-dark: #1e3a8a;
            --secondary-color: #64748b;
            --accent-color: #0ea5e9;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
            --text-dark: #1e293b;
            --white: #ffffff;
            --shadow-soft: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-strong: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--text-dark);
            line-height: 1.6;
            font-weight: 400;
        }

        /* Navigation */
        .navbar {
            background: var(--white) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            box-shadow: var(--shadow-soft);
        }

        .navbar-brand {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand .logo-square {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.2s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: var(--light-bg);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: var(--light-bg);
        }

        /* Search Bar */
        .search-container {
            position: relative;
            max-width: 300px;
        }

        .search-input {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            width: 100%;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-width: 20px;
            text-align: center;
            font-weight: 600;
        }

        /* Product Cards */
        .product-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: var(--shadow-soft);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .product-image {
            height: 200px;
            object-fit: contain;
            background: var(--light-bg);
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            border: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Typography */
        .price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .original-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            position: relative;
            overflow: hidden;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .hero-content {
            color: var(--white);
            z-index: 2;
            position: relative;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-cta {
            background: var(--white);
            color: var(--primary-color);
            font-weight: 700;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
        }

        .hero-cta:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: var(--primary-color);
        }

        /* Product Vials */
        .product-vials {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            align-items: center;
        }

        .vial {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-medium);
            width: 120px;
            height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .vial-dosage {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .vial-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.8rem;
        }

        /* Feature Section */
        .feature-section {
            background: var(--light-bg);
            padding: 4rem 0;
        }

        .feature-card {
            text-align: center;
            padding: 2rem 1rem;
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Product Grid */
        .product-grid {
            padding: 4rem 0;
            background: var(--white);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-subtitle {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        /* Filters */
        .filter-section {
            background: var(--light-bg);
            padding: 2rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            background: var(--white);
            font-size: 0.9rem;
        }

        .filter-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .product-vials {
                flex-direction: column;
                gap: 1rem;
            }
            
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>

    @stack('styles')
    @vite('resources/js/app.js')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
               <img src="{{ asset('logo.png') }}" alt="American Peptide" style="height: 40px;">
            </a>

            <!-- Search Bar -->
            <div class="search-container d-none d-lg-block mx-auto">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search">
            </div>

            <!-- Navigation Links -->
            <div class="navbar-nav mx-auto">
                <a class="nav-link" href="{{ route('products.index') }}">All Peptides</a>
                <a class="nav-link" href="{{ route('about') }}">Our Company</a>
                <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
            </div>

            <!-- User Actions -->
            <div class="navbar-nav ms-auto">
                @guest
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-person me-1"></i>Sign In
                    </a>
                @else
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.orders.index') }}">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @endguest
                
                <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                    <i class="bi bi-cart3"></i>My Cart
                    <span class="cart-badge" id="cart-count">{{ \App\Facades\Cart::getItemCount() }}</span>
                </a>
            </div>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">American Peptide</h5>
                    <p class="text-muted">High-quality research peptides for scientific use only.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-muted">All Products</a></li>
                        <li><a href="{{ route('about') }}" class="text-muted">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact Info</h5>
                    <p class="text-muted">78206 Varner Rd., Suite D #2022<br>Palm Desert, CA 92211</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                <small>&copy; {{ date('Y') }} American Peptide. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    @stack('scripts')
</body>
</html>
