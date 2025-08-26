@extends('frontend.layouts.app')

@section('title', 'About Us - Premium Peptide Research Supplier')

@section('content')
    <!-- Page Header -->
    <section class="hero-section-about" style="background-image: url('../../assets/AdobeStock_1217485389-BLUE.png');">
        <div class="hero-section-about-content">
            <article>
                <h1>About Our Research Peptide Company</h1>
                <p>Who we are, why we care, and how our values
                    support your peptide research needs.</p>
            </article>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="story-content">
                        <h2 class="section-title mb-4">Our Story</h2>
                        <article class="px-3">
                            <p class="mb-4">
                                Our company was founded on a fundamental principle: that researchers deserve access to the
                                highest
                                quality peptides with guaranteed purity and comprehensive analytical documentation. What
                                started
                                as
                                a small laboratory supply company has grown into a trusted partner for research institutions
                                worldwide.
                            </p>
                            <p class="mb-4">
                                Founded in 2020 by a team of experienced biochemists and research scientists, we began with
                                a
                                focused collection of essential research peptides. Our founders shared a vision of creating
                                more
                                than just a peptide supplier – they wanted to build a reliable partner where researchers
                                could
                                access premium quality compounds with complete confidence in their purity and authenticity.
                            </p>
                            <p class="mb-4">
                                Today, we continue to grow while maintaining our commitment to excellence. We've expanded
                                our
                                offerings to include a comprehensive range of research peptides, custom synthesis services,
                                and
                                analytical support, but our dedication to quality, reliability, and scientific integrity
                                remains
                                unchanged.
                            </p>
                        </article>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-image text-center">
                        <img src="{{ asset('../assets/Group-Shot.png') }}" alt="Research Laboratory" class="img-fluid"
                            style="max-height: 480px; object-fit: cover;">
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
                        <article class="px-2">
                            <p class="mb-4">
                                To advance scientific research by providing researchers with the highest quality peptides,
                                comprehensive analytical documentation, and exceptional technical support.
                            </p>
                            <p class="mb-4">
                                We believe that reliable, high-purity research compounds are essential for advancing
                                scientific
                                knowledge and discovery. Our mission is to be the trusted partner that enables researchers
                                to
                                focus on their groundbreaking work with complete confidence in their research materials.
                            </p>
                            <div class="mission-stats row text-center d-flex justify-content-between">
                                <div class="col-4 text-start">
                                    <div class="stat-item">
                                        <h3 class="fw-bold ms-4" style="color: #0483c6;">100+</h3>
                                        <p class="text-muted">Peptides Available</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3 class="fw-bold" style="color: #0483c6;">99.5%+</h3>
                                        <p class="text-muted">Purity Guarantee</p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="stat-item">
                                        <h3 class="fw-bold me-3" style="color: #0483c6;">500+</h3>
                                        <p class="text-muted">Research Partners</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="values-content">
                        <h2 class="section-title mb-4">Our Values</h2>
                        <div class="values-list">
                            <div class="value-item d-flex align-items-start mb-4">
                                <div class="value-icon me-3">
                                    <img src="{{ asset('../assets/about/Scientific-Excellence-Icon.png') }}" alt=""
                                        width="30">
                                </div>
                                <div class="value-content">
                                    <h4 class="h5 mb-2">Scientific Excellence</h4>
                                    <p class="text-muted mb-0">We're driven by our commitment to scientific accuracy and
                                        research integrity, ensuring every peptide meets the highest standards.</p>
                                </div>
                            </div>
                            <div class="value-item d-flex align-items-start mb-4">
                                <div class="value-icon me-3">
                                    <img src="{{ asset('../assets/about/Research-Partnership-Icon.png') }}" alt=""
                                        width="32">
                                </div>
                                <div class="value-content">
                                    <h4 class="h5 mb-2">Research Partnership</h4>
                                    <p class="text-muted mb-0">We believe in building strong relationships with researchers
                                        and institutions to advance scientific discovery together.</p>
                                </div>
                            </div>
                            <div class="value-item d-flex align-items-start mb-4">
                                <div class="value-icon me-3">
                                    <img src="{{ asset('../assets/about/Quality-Assurance-Icon.png') }}" alt=""
                                        width="32">
                                </div>
                                <div class="value-content">
                                    <h4 class="h5 mb-2">Quality Assurance</h4>
                                    <p class="text-muted mb-0">Every peptide in our collection undergoes rigorous testing to
                                        ensure the highest purity and analytical documentation.</p>
                                </div>
                            </div>
                            <div class="value-item d-flex align-items-start">
                                <div class="value-icon me-3">
                                    <img src="{{ asset('../assets/about/Innovation-Icon.png') }}" alt=""
                                        width="32">
                                </div>
                                <div class="value-content">
                                    <h4 class="h5 mb-2">Innovation</h4>
                                    <p class="text-muted mb-0">We continuously evolve our synthesis methods and analytical
                                        techniques to meet the advancing needs of research.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Why Choose Us Section -->
    <section class="why-choose-us py-5" style="background-color: #C8EAF5;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mb-3">Why Choose Our Research Peptide Company?</h2>
                <p class="section-subtitle">What makes us different from other peptide suppliers</p>
            </div>

            <div class="row g-4 d-flex justify-content-center align-items-center">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-2">
                            <img src="{{ asset('../assets/about/Highest-Quality-icon.png') }}" alt=""
                                width="28">
                        </div>
                        <h4 class="mb-3">Premium Quality</h4>
                        <p class="text-muted">Every peptide is synthesized and tested by our expert team to ensure the
                            highest purity and analytical documentation.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-2">
                            <img src="{{ asset('../assets/about/Free-Shipping-Icon.png') }}" alt="" width="32">
                        </div>
                        <h4 class="mb-3">Fast Delivery</h4>
                        <p class="text-muted">Quick and reliable shipping to get your research peptides to you as soon as
                            possible.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-2">
                            <img src="{{ asset('../assets/about/Online-Support-icon.png') }}" alt=""
                                width="32">
                        </div>
                        <h4 class="mb-3">Expert Support</h4>
                        <p class="text-muted">Our knowledgeable team is always ready to help you find the perfect peptide
                            for your research.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon mb-2">
                            <img src="{{ asset('../assets/about/Partnerships-icon.png') }}" alt=""
                                width="32">
                        </div>
                        <h4 class="mb-3">Research Partnership</h4>
                        <p class="text-muted">We're more than a peptide supplier – we're a partner in advancing scientific
                            discovery.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section py-5" style="background-color: #0483c6;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mb-3">Ready to Advance Your Research?</h2>
                    <p class="text-white mb-4">Explore our collection and discover the perfect peptides for your research
                        today.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3 mb-2">
                            <i class="bi bi-flask me-2"></i>Shop Peptides
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg mb-2">
                            <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
