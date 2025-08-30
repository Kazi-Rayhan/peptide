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

    <title>@yield('title', 'American Peptide Co.')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Font Awesome 6 Free -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart_checkout.css') }}">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v={{ uniqid() }}">
    <style>
        /* Global Styles */
        :root {
            --primary-color: #00687a;
            --secondary-color: #00a3cc;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --border-color: #dee2e6;
            --text-color: #6D6E71;
            --transition: all 0.3s ease;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 5px 20px rgba(0, 0, 0, 0.12);
            --shadow-heavy: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Table Styles */
        .table,
        .table th,
        .table td {
            color: var(--dark-color) !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .text-body-secondary {
            color: #6c757d !important;
        }

        /* Enhanced Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: var(--shadow-medium);
            border-bottom: 1px solid rgba(222, 226, 230, 0.3);
            padding: 0.75rem 0;
            transition: var(--transition);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: var(--shadow-heavy);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: clamp(1.2rem, 2.5vw, 1.5rem);
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .navbar-brand img {
            height: clamp(28px, 5vw, 40px);
            width: auto;
            transition: var(--transition);
        }

        /* Desktop Navigation */
        .navbar-nav {
            flex-direction: row;
            align-items: center;
            gap: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 0;
            position: relative;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            transition: var(--transition);
            border-radius: 1px;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            transform: translateY(-1px);
        }

        /* Enhanced Search Box */
        .search-box {
            flex: 1 1 400px;
            max-width: 450px;
            margin: 0 2rem;
            position: relative;
        }

        .search-box input[type="text"] {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            font-size: 0.95rem;
            color: var(--text-color);
            background: #fff;
            outline: none;
            transition: var(--transition);
            box-shadow: var(--shadow-light);
        }

        .search-box input[type="text"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 104, 122, 0.25), var(--shadow-medium);
            transform: translateY(-1px);
        }

        .search-box .fa-search {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color);
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-box input[type="text"]:focus+.fa-search {
            color: var(--primary-color);
        }

        /* Enhanced Icon Buttons */
        .icon-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color) !important;
            font-size: 0.95rem;
            background: none;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            position: relative;
        }

        .icon-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: var(--transition);
            z-index: -1;
        }

        .icon-btn:hover::before {
            opacity: 0.1;
        }

        .icon-btn:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .icon-btn i {
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .icon-btn:hover i {
            transform: scale(1.1);
        }

        /* Enhanced Cart Badge */
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #0483c6 !important;
            color: white !important;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 104, 122, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Enhanced Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-heavy);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            animation: dropdownFadeIn 0.3s ease;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: var(--transition);
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background: rgba(0, 104, 122, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        /* Enhanced Mobile Menu */
        .navbar-toggler {
            border: none;
            background: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler:hover {
            background: rgba(0, 104, 122, 0.1);
            transform: scale(1.05);
        }

        .navbar-toggler-icon {
            width: 24px;
            height: 24px;
            background: none;
            position: relative;
            transition: var(--transition);
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after,
        .navbar-toggler-icon div {
            content: '';
            display: block;
            height: 2px;
            width: 100%;
            background: var(--text-color);
            border-radius: 1px;
            position: absolute;
            left: 0;
            transition: var(--transition);
        }

        .navbar-toggler-icon::before {
            top: 6px;
        }

        .navbar-toggler-icon div {
            top: 12px;
        }

        .navbar-toggler-icon::after {
            top: 18px;
        }

        /* Hamburger Animation */
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 12px;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon div {
            opacity: 0;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            top: 12px;
        }

        /* Enhanced Offcanvas */
        .offcanvas {
            border: none;
            box-shadow: var(--shadow-heavy);
            background: white;
            width: 280px;
        }

        .offcanvas-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
            background: white;
        }

        .offcanvas-header .navbar-brand {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .offcanvas-header .btn-close {
            opacity: 0.7;
            transition: var(--transition);
            background: none;
            border: none;
            padding: 0.5rem;
        }

        .offcanvas-header .btn-close:hover {
            opacity: 1;
        }

        .offcanvas-body {
            padding: 0;
            background: white;
        }

        .offcanvas .search-box {
            max-width: 100%;
            margin: 0;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .offcanvas .search-box input[type="text"] {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .offcanvas .search-box input[type="text"]:focus {
            background: white;
            border-color: var(--primary-color);
            outline: none;
        }

        .offcanvas .search-box .fa-search {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .offcanvas .navbar-nav {
            flex-direction: column;
            gap: 0;
            margin: 0;
            padding: 0;
        }

        .offcanvas .nav-link {
            text-align: left;
            padding: 1rem 1.5rem;
            border: none;
            font-size: 1rem;
            color: var(--text-color) !important;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            border-bottom: 1px solid #f8f9fa;
        }

        .offcanvas .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: #6c757d;
        }

        .offcanvas .nav-link:hover,
        .offcanvas .nav-link.active {
            color: var(--primary-color) !important;
            background: #f8f9fa;
        }

        .offcanvas .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        /* Mobile Account Actions */
        .mobile-account-section {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e9ecef;
            background: white;
        }

        .mobile-account-section .section-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .mobile-account-section .icon-btn {
            justify-content: flex-start;
            width: 100%;
            padding: 0.75rem 0;
            border: none;
            color: var(--text-color) !important;
            font-size: 0.95rem;
            font-weight: 500;
            background: transparent;
            border-radius: 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .mobile-account-section .icon-btn:last-child {
            border-bottom: none;
        }

        .mobile-account-section .icon-btn:hover {
            color: var(--primary-color) !important;
            background: #f8f9fa;
        }

        .mobile-account-section .icon-btn i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: #6c757d;
        }

        .mobile-account-section .icon-btn span {
            margin-left: 0.5rem;
        }

        /* Cart badge in mobile menu */
        .mobile-account-section .cart-badge {
            position: static;
            margin-left: auto;
            background: var(--primary-color) !important;
            color: white !important;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.4rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Enhanced Floating Cart */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            display: none;
        }

        @media (max-width: 991.98px) {
            .floating-cart {
                display: block;
            }
        }

        .cart-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: var(--shadow-heavy);
            transition: var(--transition);
            position: relative;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .cart-icon-link:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 104, 122, 0.4);
            color: white;
        }

        .cart-icon-link i {
            font-size: 1.5rem;
        }

        .nav-link {
            width: 100% !important;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 991.98px) {
            .navbar .search-box {
                display: none;
            }

            .navbar-nav {
                display: none;
            }

            .navbar-brand img {
                height: 35px;
            }

            .navbar-brand {
                font-size: 1.3rem;
            }

            .icon-btn span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 0;
            }

            .navbar-brand {
                font-size: 1.2rem;
                gap: 0.5rem;
            }

            .navbar-brand img {
                height: 30px;
            }

            .icon-btn {
                padding: 0.4rem 0.6rem;
                font-size: 0.9rem;
            }

            .icon-btn i {
                font-size: 1.1rem;
            }

            .floating-cart {
                bottom: 20px;
                right: 20px;
            }

            .cart-icon-link {
                width: 50px;
                height: 50px;
            }

            .cart-icon-link i {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-brand img {
                height: 28px;
            }

            .icon-btn {
                padding: 0.3rem 0.5rem;
                font-size: 0.85rem;
            }

            .icon-btn i {
                font-size: 1rem;
            }

            .offcanvas-body {
                padding: 1.5rem 1rem;
            }

            .floating-cart {
                bottom: 15px;
                right: 15px;
            }
        }

        /* Enhanced Main Content */
        main {
            margin-top: 80px;
            min-height: calc(100vh - 80px - 300px);
            position: relative;
        }

        /* Enhanced Footer */
        .core-peptides-footer {
            background: #6e6f72;
            color: white;
            padding: 3rem 0 1rem;
            margin-top: auto;
            position: relative;
            overflow: hidden;
        }

        .core-peptides-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .footer-brand .core {
            color: var(--primary-color);
        }

        .footer-brand .peptides {
            color: var(--secondary-color);
        }

        .footer-disclaimer {
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .footer-disclaimer p {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #bdc3c7;
        }

        .footer-warning {
            background: rgba(255, 26, 1, 0.507);
            border: 1px solid rgb(255, 25, 0);
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #ffd7d3;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .footer-links-title {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            position: relative;
            z-index: 1;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .compliance-title {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .copyright {
            text-align: center;
            color: #95a5a6;
            font-size: 0.9rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #34495e;
            position: relative;
            z-index: 1;
        }

        /* Enhanced Toast Notifications */
        #toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
        }

        .alert {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-heavy);
            margin-bottom: 10px;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Loading States */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Scroll to top button */
        .scroll-to-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: var(--shadow-medium);
            transition: var(--transition);
            z-index: 999;
        }

        .scroll-to-top:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-heavy);
        }

        @media (max-width: 768px) {
            .scroll-to-top {
                bottom: 80px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4">
            <!-- Logo - Always visible -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="/logo.png" alt="American Peptide Logo" class="d-none d-lg-inline">
                <img src="/mobil-logo.png" alt="American Peptide Mobile Logo" class="d-lg-none">
            </a>

            <!-- Desktop Search - Hidden on mobile -->
            <form class="search-box d-none d-lg-block" action="{{ route('products.index') }}" method="get">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Search research peptides..."
                    value="{{ request('q') }}">
            </form>

            <!-- Desktop Navigation - Hidden on mobile -->
            <div class="d-none d-lg-flex flex-grow-1 justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">Research Peptides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- Desktop Actions - Hidden on mobile -->
            <div class="d-none d-lg-flex align-items-center gap-3">
                <a class="icon-btn position-relative" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count-navbar" class="cart-badge">{{ \App\Facades\Cart::getItemCount() }}</span>
                </a>

                <div class="dropdown">
                    <a class="icon-btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="far fa-user"></i>
                        <span>Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Sign in
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a></li>
                        @endguest
                        @auth
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

            <!-- Mobile Actions - Visible only on mobile -->
            <div class="d-lg-none d-flex align-items-center gap-2">
                {{-- <a class="icon-btn position-relative" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count-mobile" class="cart-badge">0</span>
                </a> --}}

                <a class="icon-btn" href="{{ route('login') }}">
                    <i class="far fa-user"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                    aria-controls="mobileMenu">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="American Peptide Mobile Logo">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">


            <!-- Mobile Navigation -->
            <ul class="navbar-nav d-flex flex-column align-items-start mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                        <i class="fas fa-flask "></i>Research Peptides
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">
                        <i class="fas fa-building "></i>About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="fas fa-envelope "></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Mobile Account Actions -->
            <div class="mobile-account-section text-dark">
                <h6 class="section-title">Account</h6>
                @guest
                    <ul class="navbar-nav d-flex flex-column align-items-start mb-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Sign in</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </li>

                    </ul>
                @else
                    <ul class="navbar-nav d-flex flex-column align-items-start mb-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                @endguest

                {{-- <ul class="navbar-nav d-flex flex-column align-items-start mb-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Cart</span>
                        </a>
                    </li>
                </ul> --}}
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="fade-in-up">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="core-peptides-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="footer-brand">
                        <img src="{{ asset('assets/APC Logo White.png') }}" alt="American Peptide Logo"
                            class="w-50 img-fluid">
                    </div>
                    <div class="footer-disclaimer">
                        <p>All products are sold for research, laboratory, or analytical purposes only, and are not for
                            human consumption.</p>
                        <p>American Peptides is a chemical supplier. We are not a compounding pharmacy or chemical
                            compounding facility as defined under 503A of the Federal Food, Drug, and Cosmetic act.</p>
                        <p>The statements made within this website have not been evaluated by the US Food and Drug
                            Administration. The products we offer are not intended to diagnose, treat, cure or prevent
                            any disease.</p>
                    </div>
                    <div class="footer-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Human/Animal Consumption Prohibited: Laboratory/in-Vitro Experimental Use Only
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-links-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}">Research Peptides</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="compliance-title">Payment Methods</h5>
                    <img src="{{ asset('assets/images/home/payment.png') }}" alt="Payment Methods"
                        class="img-fluid">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="copyright">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> American Peptides. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top text-secondary " id="scrollToTop" style="background: #c8eaf5 !important;"
        title="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </button>
    <!-- Toast Container -->
    <div id="toast-container"></div>

    <!-- Floating Cart for Mobile -->
    <div class="floating-cart d-lg-none" id="floatingCart">
        <a href="{{ route('cart.index') }}" class="cart-icon-link">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count-floating" class="cart-badge">0</span>
        </a>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    </script>


    <script>
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    console.log('Cart count response:', data);

                    const count = data.cart_count ?? 0;

                    const navbarBadge = document.getElementById('cart-count-navbar');
                    const floatingBadge = document.getElementById('cart-count-floating');

                    if (navbarBadge) navbarBadge.textContent = count;
                    if (floatingBadge) floatingBadge.textContent = count;
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                });
        }
        document.addEventListener('DOMContentLoaded', function() {


            updateCartCount(); // initial load
        });

        // Enhanced Toast notifications
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('fade');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Enhanced Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Show/hide scroll to top button
            const scrollToTop = document.getElementById('scrollToTop');
            if (window.scrollY > 300) {
                scrollToTop.style.display = 'flex';
            } else {
                scrollToTop.style.display = 'none';
            }
        });

        // Scroll to top functionality
        document.getElementById('scrollToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Enhanced mobile menu close on link click
        document.querySelectorAll('.offcanvas .nav-link, .offcanvas .icon-btn').forEach(link => {
            link.addEventListener('click', function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('mobileMenu'));
                if (offcanvas) {
                    offcanvas.hide();
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Add loading states to forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                    }
                });
            });
        });
    </script>



    @stack('scripts')
</body>

</html>
