@extends('frontend.layouts.app')

@section('title', 'About Us - Premium Peptide Research Supplier')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="text-white display-4 fw-bold mb-3">About Our Research Peptide Company</h1>
                <p class="text-white lead mb-0">Our story, mission, and the team behind your research peptide needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="our-story py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="story-content">
                    <h2 class="section-title mb-4">Our Story</h2>
                    <p class="lead mb-4">
                        Our company was founded on a fundamental principle: that researchers deserve access to the highest 
                        quality peptides with guaranteed purity and comprehensive analytical documentation. What started as 
                        a small laboratory supply company has grown into a trusted partner for research institutions worldwide.
                    </p>
                    <p class="mb-4">
                        Founded in 2020 by a team of experienced biochemists and research scientists, we began with a 
                        focused collection of essential research peptides. Our founders shared a vision of creating more 
                        than just a peptide supplier – they wanted to build a reliable partner where researchers could 
                        access premium quality compounds with complete confidence in their purity and authenticity.
                    </p>
                    <p class="mb-4">
                        Today, we continue to grow while maintaining our commitment to excellence. We've expanded our 
                        offerings to include a comprehensive range of research peptides, custom synthesis services, and 
                        analytical support, but our dedication to quality, reliability, and scientific integrity remains unchanged.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="story-image text-center">
                    <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Research Laboratory" 
                         class="img-fluid rounded-3 shadow-lg" 
                         style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values Section -->
<section class="mission-values py-5" style="background: var(--light-bg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="mission-content">
                    <h2 class="section-title mb-4">Our Mission</h2>
                    <p class="lead mb-4">
                        To advance scientific research by providing researchers with the highest quality peptides, 
                        comprehensive analytical documentation, and exceptional technical support.
                    </p>
                    <p class="mb-4">
                        We believe that reliable, high-purity research compounds are essential for advancing scientific 
                        knowledge and discovery. Our mission is to be the trusted partner that enables researchers to 
                        focus on their groundbreaking work with complete confidence in their research materials.
                    </p>
                    <div class="mission-stats row text-center">
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold" style="color: var(--primary-color);">500+</h3>
                                <p class="text-muted">Peptides Available</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold" style="color: var(--primary-color);">99.5%+</h3>
                                <p class="text-muted">Purity Guarantee</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h3 class="fw-bold" style="color: var(--primary-color);">1000+</h3>
                                <p class="text-muted">Research Partners</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="values-content">
                    <h2 class="section-title mb-4">Our Values</h2>
                    <div class="values-list">
                        <div class="value-item d-flex align-items-start mb-4">
                            <div class="value-icon me-3">
                                <i class="bi bi-heart-fill fs-4" style="color: var(--primary-color);"></i>
                            </div>
                            <div class="value-content">
                                <h4 class="h5 mb-2">Scientific Excellence</h4>
                                <p class="text-muted mb-0">We're driven by our commitment to scientific accuracy and research integrity, ensuring every peptide meets the highest standards.</p>
                            </div>
                        </div>
                        <div class="value-item d-flex align-items-start mb-4">
                            <div class="value-icon me-3">
                                <i class="bi bi-people-fill fs-4" style="color: var(--secondary-color);"></i>
                            </div>
                            <div class="value-content">
                                <h4 class="h5 mb-2">Research Partnership</h4>
                                <p class="text-muted mb-0">We believe in building strong relationships with researchers and institutions to advance scientific discovery together.</p>
                            </div>
                        </div>
                        <div class="value-item d-flex align-items-start mb-4">
                            <div class="value-icon me-3">
                                <i class="bi bi-award-fill fs-4" style="color: var(--success-color);"></i>
                            </div>
                            <div class="value-content">
                                <h4 class="h5 mb-2">Quality Assurance</h4>
                                <p class="text-muted mb-0">Every peptide in our collection undergoes rigorous testing to ensure the highest purity and analytical documentation.</p>
                            </div>
                        </div>
                        <div class="value-item d-flex align-items-start">
                            <div class="value-icon me-3">
                                <i class="bi bi-lightbulb-fill fs-4" style="color: var(--warning-color);"></i>
                            </div>
                            <div class="value-content">
                                <h4 class="h5 mb-2">Innovation</h4>
                                <p class="text-muted mb-0">We continuously evolve our synthesis methods and analytical techniques to meet the advancing needs of research.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">Meet Our Team</h2>
            <p class="section-subtitle">The experienced scientists behind our research peptide company</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="team-member text-center">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                             alt="Sarah Johnson" 
                             class="img-fluid rounded-circle shadow" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    <h4 class="h5 mb-2">Dr. Sarah Johnson</h4>
                    <p class="text-muted mb-2">Founder & CEO</p>
                    <p class="small text-muted">
                        A PhD in Biochemistry with 15+ years in peptide research. Dr. Johnson's vision drives our mission to provide researchers with the highest quality compounds.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-member text-center">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                             alt="Michael Chen" 
                             class="img-fluid rounded-circle shadow" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    <h4 class="h5 mb-2">Dr. Michael Chen</h4>
                    <p class="text-muted mb-2">Head of Quality Control</p>
                    <p class="small text-muted">
                        With a PhD in Analytical Chemistry, Dr. Chen ensures every peptide meets our rigorous purity standards and analytical requirements.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="team-member text-center">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" 
                             alt="Emily Rodriguez" 
                             class="img-fluid rounded-circle shadow" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    <h4 class="h5 mb-2">Dr. Emily Rodriguez</h4>
                    <p class="text-muted mb-2">Technical Support Manager</p>
                    <p class="small text-muted">
                        Dr. Rodriguez ensures every researcher receives exceptional technical support, from peptide selection to experimental guidance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-us py-5" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">Why Choose Our Research Peptide Company?</h2>
            <p class="section-subtitle">What makes us different from other peptide suppliers</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-search fs-1" style="color: var(--primary-color);"></i>
                    </div>
                    <h4 class="h5 mb-3">Premium Quality</h4>
                    <p class="text-muted">Every peptide is synthesized and tested by our expert team to ensure the highest purity and analytical documentation.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-truck fs-1" style="color: var(--secondary-color);"></i>
                    </div>
                    <h4 class="h5 mb-3">Fast Delivery</h4>
                    <p class="text-muted">Quick and reliable shipping to get your books to you as soon as possible.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-headset fs-1" style="color: var(--info-color);"></i>
                    </div>
                    <h4 class="h5 mb-3">Expert Support</h4>
                    <p class="text-muted">Our knowledgeable team is always ready to help you find the perfect book.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-heart fs-1" style="color: var(--danger-color);"></i>
                    </div>
                    <h4 class="h5 mb-3">Community Focus</h4>
                    <p class="text-muted">We're more than a bookstore – we're a community of passionate readers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white mb-3">Ready to Start Your Reading Journey?</h2>
                <p class="text-white mb-4">Explore our collection and discover your next favorite book today.</p>
                <div class="cta-buttons">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3 mb-2">
                        <i class="bi bi-book me-2"></i>Browse Books
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg mb-2">
                        <i class="bi bi-envelope me-2"></i>Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 