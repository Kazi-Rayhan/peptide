@extends('frontend.layouts.app')

@section('content')
    <main>
        <section class="hero-section" style="background-image: url('{{asset('assets/DNAimage.jpg')}}')">
            <div class="hero-section__content">
                <article>
                    <h1>99% Pure Peptides</h1>
                    <h3>High quality peptides</h3>
                    <p>Proudly synthesized by industry <br> leading scientists</p>
                    <a href="{{ route('products.index') }}">SHOP PEPTIDES</a>
                </article>
                <figure>
                    <img src="{{ asset('assets/peptideHero.png') }}" alt="Peptides">
                </figure>
            </div>
        </section>
        <section class="services-section">
            <div class="services-section__content">
                <article>
                    <figure>
                        <img src="{{ asset('assets/Free Shipping Icon.png') }}" alt="Peptides">
                    </figure>
                    <div>
                        <h2>Free Delivery</h2>
                        <p>Any purchase of $200 or more qualifies for free delivery within the USA </p>
                    </div>
                </article>
                <article>
                    <figure>
                        <img src="{{ asset('assets/Highest Quality Icon.png') }}" alt="Peptides">
                    </figure>
                    <div>
                        <h2>Highest Quality</h2>
                        <p>Our products are third-party tested by Chomate laboratories, to insure the highest potency and
                            purity </p>
                    </div>
                </article>
                <article>
                    <figure>
                        <img src="{{ asset('assets/Online Support Icon.png') }}" alt="Peptides">
                    </figure>
                    <div>
                        <h2>Online Support</h2>
                        <p>Have questions? We can help. Email us or connect with us via our Contact page.</p>
                    </div>
                </article>

            </div>
        </section>
        <section class="products-section">

            <div class="container">
                <h2>Research Peptides for Sale</h2>

                <div class="row">

                    @foreach ($products as $product)
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('components.product.newsletter-section')
@endsection
