@extends('frontend.layouts.app')

@section('title', 'American Peptide - High Quality Research Peptides')

@section('content')
    @php
        $featuredProducts = \App\Models\Product::with(['category'])
            ->limit(8)
            ->get();
    @endphp
    <!-- Hero Section -->
    <section class="hero-section"
        style="background-image: url('{{ asset('assets/DNAimage.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mx-auto" 
                style="background-color: rgba(255, 255, 255, 0.849); padding: 20px; border-radius: 20px;width: 70%;">

                <div class="hero-content">
                    <div class="d-flex flex-column gap-2 h-100">
                        <div>
                            <h1 style="font-size: 3.2rem;" class="hero-title text-primary">99% PURE PEPTIDES</h1>
                            <h2 style="font-size: 1.8rem;" class="hero-subtitle text-secondary">High Quality Peptides</h2>
                            <p style="font-size: 1.2rem;" class="hero-description text-secondary">Proudly synthesized by industry <br> leading scientists</p>
                        </div>
                        <div>

                            <a  href="{{ route('products.index') }}" class="" style="background-color: rgb(16,128,198); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;font-weight: bold; font-size: 1.2rem;">BUY PEPTIDES</a>
                        </div>
                    </div>
                </div>

                <img src="{{ asset('assets/peptides.png') }}" style="height:300px" alt="Hero Image" class="img-fluid">

            </div>
        </div>
    </section>

    <!-- Feature Highlights Section -->
    <section class="feature-section" style="background-color: #C9EAF5;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h3 class="feature-title">FREE SHIPPING</h3>
                        <p class="feature-description">Any purchase of $300 or more qualifies for free delivery within the
                            USA.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <h3 class="feature-title">HIGHEST QUALITY</h3>
                        <p class="feature-description">Our products are third-party tested by Chomate laboratories, to
                            insure the highest potency and purity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h3 class="feature-title">ONLINE SUPPORT</h3>
                        <p class="feature-description">Have questions? We can help. Email us or connect with us via our
                            Contact page.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Grid Section -->
    <section class="product-grid">
        <div class="container">
            <h2 class="section-title">RESEARCH PEPTIDES FOR SALE</h2>
            <p class="section-subtitle">High-quality peptides for research purposes only</p>

            <!-- Filter Section -->
            <div class="filter-section" style="border:none">
                <div class="filter-controls">
                    <div class="filter-group">
                        <span class="text-muted">Showing all {{ $featuredProducts->count() }} results</span>
                    </div>
                    <div class="filter-group">
                        <select class="filter-select">
                            <option>Price</option>
                            <option>Low to High</option>
                            <option>High to Low</option>
                        </select>
                        <select class="filter-select">
                            <option>Categories</option>
                            <option>All Peptides</option>
                            <option>Research Peptides</option>
                        </select>
                        <label class="filter-checkbox">
                            <input type="checkbox"> On Sale
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox"> In Stock
                        </label>
                        <select class="filter-select">
                            <option>Sort by title (A-Z)</option>
                            <option>Sort by title (Z-A)</option>
                            <option>Sort by price (Low-High)</option>
                            <option>Sort by price (High-Low)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="row g-4">


                @forelse($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Research Disclaimer Section -->
    <section class="py-4 bg-warning">
        <div class="container">
            <div class="text-center">
                <div class="alert alert-warning border-0 mb-0" style="background: transparent;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Research Use Only:</strong> All products are for research purposes only. Not for human
                    consumption.
                </div>
            </div>
        </div>
    </section>
@endsection
