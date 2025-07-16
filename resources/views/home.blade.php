@extends('frontend.layouts.app')

@section('title', 'American Peptide - High Quality Research Peptides')

@section('content')
<!-- Hero Section with DNA Background -->
<section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); position: relative; overflow: hidden;">
    <!-- DNA Background Pattern -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1;">
        <svg width="100%" height="100%" viewBox="0 0 1000 600" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dna" x="0" y="0" width="100" height="200" patternUnits="userSpaceOnUse">
                    <path d="M50 0 Q75 50 50 100 Q25 150 50 200" stroke="var(--text-dark)" stroke-width="2" fill="none"/>
                    <path d="M50 0 Q25 50 50 100 Q75 150 50 200" stroke="var(--text-dark)" stroke-width="2" fill="none"/>
                    <circle cx="50" cy="50" r="3" fill="var(--text-dark)"/>
                    <circle cx="50" cy="150" r="3" fill="var(--text-dark)"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dna)"/>
        </svg>
    </div>
    
    <div class="container position-relative">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="hero-content text-white">
                    <h1 class="display-3 fw-bold mb-4" style="font-family: 'Inter', sans-serif;">
                        99% PURE PEPTIDES
                    </h1>
                    <h2 class="h2 mb-4" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        High Quality Peptides
                    </h2>
                    <p class="lead mb-4" style="font-size: 1.2rem;">
                        Proudly synthesized by industry leading scientists
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3 mb-2 fw-bold" style="background: var(--white); color: var(--text-dark);">
                            BUY PEPTIDES
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg mb-2">
                            <i class="bi bi-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <div class="d-flex justify-content-center gap-3">
                        <div class="text-center">
                            <div class="bg-white rounded-3 p-3 mb-2 shadow-lg" style="width: 120px; height: 120px; display: inline-flex; align-items: center; justify-content: center;">
                                <div class="text-center">
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem;">10mg</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">RETA</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-white rounded-3 p-3 mb-2 shadow-lg" style="width: 120px; height: 120px; display: inline-flex; align-items: center; justify-content: center;">
                                <div class="text-center">
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem;">50mg</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">GLOW</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-white rounded-3 p-3 mb-2 shadow-lg" style="width: 120px; height: 120px; display: inline-flex; align-items: center; justify-content: center;">
                                <div class="text-center">
                                    <div class="fw-bold text-primary" style="font-size: 0.9rem;">CJC-1295</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">IPA</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feature Highlights Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-truck fs-1" style="color: var(--primary-color);"></i>
                    </div>
                    <h4 class="h5 mb-3 fw-bold">FREE SHIPPING</h4>
                    <p class="text-muted">Any purchase of $300 or more qualifies for free delivery within the USA.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-award fs-1" style="color: var(--primary-color);"></i>
                    </div>
                    <h4 class="h5 mb-3 fw-bold">HIGHEST QUALITY</h4>
                    <p class="text-muted">Our products are third-party tested by Chomate laboratories, to insure the highest potency and purity.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-headset fs-1" style="color: var(--primary-color);"></i>
                    </div>
                    <h4 class="h5 mb-3 fw-bold">ONLINE SUPPORT</h4>
                    <p class="text-muted">Have questions? We can help. Email us or connect with us via our Contact page.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3 fw-bold">RESEARCH PEPTIDES FOR SALE</h2>
            <p class="section-subtitle">High-quality peptides for research purposes only</p>
        </div>
        
        <div class="row g-4">
            @php
                $featuredProducts = \App\Models\Product::with(['category'])
                  
                    ->limit(8)
                    ->get();
            @endphp
            
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
                <strong>Research Use Only:</strong> All products are for research purposes only. Not for human consumption.
            </div>
        </div>
    </div>
</section>

<script>
function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            updateCartCount();
            
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                Product added to cart successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 3000);
        } else {
            // Show error message
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                ${data.message || 'Error adding product to cart'}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error message
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            Error adding product to cart
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 3000);
    });
}
</script>
@endsection
