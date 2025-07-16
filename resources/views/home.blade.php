@extends('frontend.layouts.app')

@section('title', 'American Peptides - Premium Research Peptides')

<style>
    .hero-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("{{ asset('assets/images/home/gradient_home_first.png') }}");
        background-size: cover;
        background-position: center;
        opacity: 0.1;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 2rem;
        max-width: 600px;
    }

    .hero-btn {
        background: linear-gradient(45deg, #00687a, #00a3cc);
        border: none;
        padding: clamp(12px, 2vw, 18px) clamp(25px, 4vw, 45px);
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        font-weight: 600;
        color: white;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 104, 122, 0.3);
        position: relative;
        overflow: hidden;
    }

    .hero-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .hero-btn:hover::before {
        left: 100%;
    }

    .hero-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 104, 122, 0.4);
        color: white;
        text-decoration: none;
    }

    .hero-image {
        max-width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .hero-image:hover {
        transform: scale(1.02);
    }

    .features-section {
        background: #fff;
        padding: clamp(60px, 8vw, 100px) 0;
        position: relative;
    }

    .features-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #dee2e6, transparent);
    }

    .feature-card {
        text-align: center;
        padding: clamp(1.5rem, 3vw, 2.5rem);
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid #f8f9fa;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(45deg, #00687a, #00a3cc);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: clamp(60px, 8vw, 80px);
        height: clamp(60px, 8vw, 80px);
        margin: 0 auto 1.5rem;
        background: linear-gradient(45deg, #00687a, #00a3cc);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: clamp(1.5rem, 3vw, 2rem);
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .feature-title {
        font-size: clamp(1.1rem, 2.5vw, 1.25rem);
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .feature-text {
        color: #6c757d;
        line-height: 1.6;
        margin: 0;
        font-size: clamp(0.9rem, 2vw, 1rem);
    }

    .products-section {
        padding: clamp(60px, 8vw, 100px) 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: clamp(2rem, 5vw, 4rem);
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(45deg, #00687a, #00a3cc);
        border-radius: 2px;
    }

    .section-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .filter-bar {
        background: white;
        padding: clamp(1rem, 3vw, 1.5rem);
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border: 1px solid #f8f9fa;
    }

    .filter-bar .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .filter-bar .form-select:focus {
        border-color: #00687a;
        box-shadow: 0 0 0 0.2rem rgba(0, 104, 122, 0.25);
    }

    .category-section {
        background: linear-gradient(135deg, #00687a 0%, #00a3cc 100%);
        padding: clamp(60px, 8vw, 100px) 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .category-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .category-card {
        text-align: center;
        padding: clamp(1.5rem, 3vw, 2.5rem);
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover::before {
        opacity: 1;
    }

    .category-card:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .category-icon {
        width: clamp(80px, 10vw, 100px);
        height: clamp(80px, 10vw, 100px);
        margin: 0 auto 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.3);
    }

    .category-title {
        font-size: clamp(1.25rem, 3vw, 1.5rem);
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .category-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: clamp(8px, 2vw, 12px) clamp(20px, 3vw, 30px);
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: clamp(0.9rem, 2vw, 1rem);
        position: relative;
        z-index: 1;
        display: inline-block;
    }

    .category-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .newsletter-section {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: clamp(60px, 8vw, 100px) 0;
        color: white;
        position: relative;
    }

    .newsletter-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M20 20c0 11.046-8.954 20-20 20v-40c11.046 0 20 8.954 20 20z'/%3E%3C/g%3E%3C/svg%3E");
    }

    .newsletter-form {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .newsletter-input {
        border: none;
        border-radius: 12px;
        padding: clamp(12px, 2vw, 18px) clamp(15px, 3vw, 25px);
        font-size: clamp(0.9rem, 2vw, 1rem);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .newsletter-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
        color: white;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        outline: none;
    }

    .newsletter-btn {
        background: linear-gradient(45deg, #00687a, #00a3cc);
        border: none;
        border-radius: 12px;
        padding: clamp(12px, 2vw, 18px) clamp(20px, 3vw, 35px);
        font-weight: 600;
        font-size: clamp(0.9rem, 2vw, 1rem);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .newsletter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .newsletter-btn:hover::before {
        left: 100%;
    }

    .newsletter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 104, 122, 0.4);
    }

    /* Enhanced Mobile Responsive */
    @media (max-width: 991.98px) {
        .hero-section {
            padding: 100px 0 60px;
            min-height: auto;
        }

        .hero-content {
            text-align: center;
            margin-bottom: 2rem;
        }

        .hero-image {
            max-width: 80%;
            margin: 0 auto;
        }

        .feature-card {
            margin-bottom: 2rem;
        }

        .category-card {
            margin-bottom: 2rem;
        }

        .newsletter-form .row {
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 0 40px;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .filter-bar {
            padding: 1rem;
        }

        .filter-bar .row {
            gap: 1rem;
        }

        .filter-bar .col-md-6 {
            width: 100%;
        }

        .newsletter-form .col-md-3,
        .newsletter-form .col-md-2 {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            padding: 60px 0 30px;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-btn {
            padding: 12px 25px;
            font-size: 0.95rem;
            width: 100%;
            justify-content: center;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .filter-bar {
            padding: 1rem;
        }

        .feature-card,
        .category-card {
            padding: 1.5rem;
        }

        .newsletter-section {
            padding: 40px 0;
        }
    }

    /* Animation Classes */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .fade-in-left {
        animation: fadeInLeft 0.8s ease-out;
    }

    .fade-in-right {
        animation: fadeInRight 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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
</style>

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background-image: url('{{ asset('assets/DNAimage.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container" style="background-color: rgba(255, 252, 252, 0.87);padding: 40px;border-radius: 30px">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content fade-in-left">
                <h1 class="hero-title fw-bold">Highest Quality Peptides For Sale</h1>
                <p class="hero-subtitle">
                    We are proud to carry the highest quality peptides and peptide blends in the research industry. 
                    All products undergo rigorous quality control procedures.
                </p>
                <a href="{{ route('products.index') }}" class="hero-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span>SHOP PEPTIDES</span>
                </a>
            </div>
            <div class="col-lg-6 text-center ">
                <img src="{{ asset('assets/peptides.png') }}" class="img-fluid" alt="Research Peptides" >
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" style="background-color: #8fb5db;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.1s;">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="feature-title">Free Delivery</h5>
                    <p class="feature-text">
                        Any purchase of $200 or more qualifies for free delivery within the USA.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.2s;">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5 class="feature-title">Highest Quality Peptides</h5>
                    <p class="feature-text">
                        Our products are scientifically-formulated and produced in cGMP facilities.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" style="animation-delay: 0.3s;">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="feature-title">Online Support</h5>
                    <p class="feature-text">
                        Have questions? We can help. Email us or connect via our Contact page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title">Research Peptides For Sale</h2>
            <p class="section-subtitle">
                Discover our comprehensive collection of high-quality research peptides
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar fade-in-up" style="animation-delay: 0.1s;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">Showing all {{ $products->count() }} results</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <select class="form-select d-inline-block w-auto">
                        <option value="popularity">Sort by popularity</option>
                        <option value="date">Sort by latest</option>
                        <option value="price">Sort by price: low to high</option>
                        <option value="price-desc">Sort by price: high to low</option>
                        <option value="title" selected>Sort by title (A-Z)</option>
                        <option value="title-desc">Sort by title (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row">
            @foreach ($products as $index => $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4 fade-in-up" style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Category Section -->
<section class="category-section">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title text-white">Product Categories</h2>
            <p class="section-subtitle text-white-50">
                Explore our specialized peptide categories
            </p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4 fade-in-left" style="animation-delay: 0.1s;">
                <div class="category-card">
                    <div class="category-icon">
                        <img src="{{ asset('assets/images/home/pep.svg') }}" alt="Peptides" style="width: 50px; height: 50px;">
                    </div>
                    <h4 class="category-title">Peptides</h4>
                    <p class="mb-3">High-quality individual peptides for research purposes</p>
                    <a href="#" class="category-btn">Explore Peptides</a>
                </div>
            </div>
            <div class="col-lg-6 mb-4 fade-in-right" style="animation-delay: 0.2s;">
                <div class="category-card">
                    <div class="category-icon">
                        <img src="{{ asset('assets/images/home/pep_blend.svg') }}" alt="Peptide Blends" style="width: 50px; height: 50px;">
                    </div>
                    <h4 class="category-title">Peptide Blends</h4>
                    <p class="mb-3">Specialized peptide combinations for advanced research</p>
                    <a href="#" class="category-btn">Explore Blends</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="section-title text-white">Stay Updated</h2>
            <p class="section-subtitle text-white-50">
                Subscribe to our newsletter for exclusive promotions and research updates
            </p>
        </div>

        <form action="" method="POST" class="newsletter-form fade-in-up" style="animation-delay: 0.1s;">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="first_name" class="form-control newsletter-input" 
                           placeholder="First Name" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control newsletter-input" 
                           placeholder="Email Address" required>
                </div>
                <div class="col-md-3">
                    <input type="tel" name="phone" class="form-control newsletter-input" 
                           placeholder="Contact Number" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn newsletter-btn w-100">
                        <i class="fas fa-paper-plane me-2"></i>Subscribe
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
function addToCart(productId) {
    const btn = event.target.closest('.btn');
    const originalText = btn.innerHTML;
    
    // Add loading state
    btn.classList.add('btn-loading');
    btn.innerHTML = '<span>Adding...</span>';
    
    fetch('{{ route('cart.add') }}', {
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
            updateCartCount();
            showToast('Product added to cart successfully!', 'success');
        } else {
            showToast(data.message || 'Error adding product to cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding product to cart', 'danger');
    })
    .finally(() => {
        // Remove loading state
        btn.classList.remove('btn-loading');
        btn.innerHTML = originalText;
    });
}

// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });
});
</script>
@endsection
