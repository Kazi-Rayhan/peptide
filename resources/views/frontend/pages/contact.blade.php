@extends('frontend.layouts.app')

@section('title', 'Contact Us - Eterna Reads')

@section('content')
    <!-- Page Header -->
    <section class="page-header py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="text-white display-4 fw-bold mb-3">Contact Us</h1>
                    <p class="text-white lead mb-0">We'd love to hear from you. Get in touch with our team.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                        <div class="contact-icon mb-3">
                            <i class="bi bi-geo-alt-fill fs-1" style="color: var(--primary-color);"></i>
                        </div>
                        <h4 class="h5 mb-3">Visit Our Store</h4>
                        <p class="text-muted mb-0">
                            123 Book Street<br>
                            Literary City, LC 12345<br>
                            United States
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                        <div class="contact-icon mb-3">
                            <i class="bi bi-telephone-fill fs-1" style="color: var(--secondary-color);"></i>
                        </div>
                        <h4 class="h5 mb-3">Call Us</h4>
                        <p class="text-muted mb-0">
                            <a href="tel:+15551234567" class="text-decoration-none">+1 (555) 123-4567</a><br>
                            Monday - Friday: 9AM - 6PM<br>
                            Saturday: 10AM - 4PM
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card text-center p-4 bg-white rounded-3 shadow-sm h-100">
                        <div class="contact-icon mb-3">
                            <i class="bi bi-envelope-fill fs-1" style="color: var(--info-color);"></i>
                        </div>
                        <h4 class="h5 mb-3">Email Us</h4>
                        <p class="text-muted mb-0">
                            <a href="mailto:hello@eternareads.com"
                                class="text-decoration-none">hello@eternareads.com</a><br>
                            <a href="mailto:support@eternareads.com"
                                class="text-decoration-none">support@eternareads.com</a><br>
                            We'll respond within 24 hours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form py-5" style="background: var(--light-bg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h2 class="section-title mb-3">Send Us a Message</h2>
                        <p class="section-subtitle">Have a question, suggestion, or just want to say hello? We'd love to
                            hear from you!</p>
                    </div>

                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <form action="{{ route('contact.store') }}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name *</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <select class="form-select @error('subject') is-invalid @enderror" id="subject"
                                            name="subject" required>
                                            <option value="">Select a subject</option>
                                            <option value="General Inquiry"
                                                {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry
                                            </option>
                                            <option value="Book Recommendation"
                                                {{ old('subject') == 'Book Recommendation' ? 'selected' : '' }}>Book
                                                Recommendation</option>
                                            <option value="Order Support"
                                                {{ old('subject') == 'Order Support' ? 'selected' : '' }}>Order Support
                                            </option>
                                            <option value="Gift Box Inquiry"
                                                {{ old('subject') == 'Gift Box Inquiry' ? 'selected' : '' }}>Gift Box
                                                Inquiry</option>
                                            <option value="Audiobook Support"
                                                {{ old('subject') == 'Audiobook Support' ? 'selected' : '' }}>Audiobook
                                                Support</option>
                                            <option value="Partnership"
                                                {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership
                                            </option>
                                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message *</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6"
                                            placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input @error('newsletter') is-invalid @enderror"
                                                type="checkbox" id="newsletter" name="newsletter"
                                                {{ old('newsletter') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="newsletter">
                                                Subscribe to our newsletter for book recommendations and updates
                                            </label>
                                            @error('newsletter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="bi bi-send me-2"></i>Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mb-3">Find Our Store</h2>
                <p class="section-subtitle">Visit us in person to experience our curated collection</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-0">
                            <!-- Google Maps Embed -->
                            <div class="ratio ratio-21x9">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007%2C%20USA!5e0!3m2!1sen!2sin!4v1640995200000!5m2!1sen!2sin"
                                    style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Store Hours Section -->
    <section class="store-hours py-5" style="background: var(--light-bg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-5">
                        <h2 class="section-title mb-3">Store Hours</h2>
                        <p class="section-subtitle">Plan your visit to our physical store</p>
                    </div>

                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mb-3">Monday - Friday</h5>
                                    <p class="text-muted">9:00 AM - 6:00 PM</p>

                                    <h5 class="mb-3">Saturday</h5>
                                    <p class="text-muted">10:00 AM - 4:00 PM</p>

                                    <h5 class="mb-3">Sunday</h5>
                                    <p class="text-muted">Closed</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-3">Holiday Hours</h5>
                                    <p class="text-muted small">
                                        We may have modified hours during holidays.
                                        Please call ahead or check our social media for updates.
                                    </p>

                                    <h5 class="mb-3">Special Events</h5>
                                    <p class="text-muted small">
                                        We host book clubs, author readings, and other literary events.
                                        Check our blog for upcoming events.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Preview Section -->
    <section class="faq-preview py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title mb-3">Frequently Asked Questions</h2>
                    <p class="section-subtitle mb-4">Find quick answers to common questions</p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="faq-item text-start">
                                <h5 class="mb-2">
                                    <i class="bi bi-question-circle me-2" style="color: var(--primary-color);"></i>
                                    How do I track my order?
                                </h5>
                                <p class="text-muted small">You'll receive a tracking number via email once your order
                                    ships.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item text-start">
                                <h5 class="mb-2">
                                    <i class="bi bi-question-circle me-2" style="color: var(--primary-color);"></i>
                                    What's your return policy?
                                </h5>
                                <p class="text-muted small">We accept returns within 30 days for books in original
                                    condition.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item text-start">
                                <h5 class="mb-2">
                                    <i class="bi bi-question-circle me-2" style="color: var(--primary-color);"></i>
                                    Do you ship internationally?
                                </h5>
                                <p class="text-muted small">Yes, we ship to most countries. Shipping rates vary by
                                    location.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="faq-item text-start">
                                <h5 class="mb-2">
                                    <i class="bi bi-question-circle me-2" style="color: var(--primary-color);"></i>
                                    Can I get book recommendations?
                                </h5>
                                <p class="text-muted small">Absolutely! Our team loves helping readers find their next
                                    favorite book.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('faq') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-question-circle me-2"></i>View All FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section py-5"
        style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mb-3">Still Have Questions?</h2>
                    <p class="text-white mb-4">Our friendly team is here to help you find the perfect book or answer any
                        questions you might have.</p>
                    <div class="cta-buttons">
                        <a href="tel:+15551234567" class="btn btn-light btn-lg me-3 mb-2">
                            <i class="bi bi-telephone me-2"></i>Call Us Now
                        </a>
                        <a href="mailto:hello@eternareads.com" class="btn btn-outline-light btn-lg mb-2">
                            <i class="bi bi-envelope me-2"></i>Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
