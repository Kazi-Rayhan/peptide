@extends('frontend.layouts.app')

@section('title', $product->name . ' - MyShop')

@section('content')
    <style>
        .variant-option {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.3s, background 0.3s;
            background: #fff;
            cursor: pointer;
            position: relative;
        }

        .variant-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .variant-checkmark {
            display: none;
            font-size: 1.3rem;
            color: #28a745;
            margin-left: 16px;
            margin-right: 0;
        }

        .variant-option .form-check-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .variant-option .form-check-label {
            flex: 1;
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .variant-option .variant-price {
            font-weight: 600;
            color: #28a745;
            font-size: 1.1rem;
            margin-left: 16px;
        }

        .variant-option input[type="radio"]:checked+.form-check-label {
            color: #222;
            font-weight: 700;
        }

        .variant-option input[type="radio"]:checked~.variant-price {
            font-weight: 700;
            color: #218838;
        }

        .variant-option input[type="radio"]:checked~.variant-checkmark {
            display: inline-block;
        }

        .variant-option input[type="radio"]:checked~.form-check-label {
            color: #222;
            font-weight: 700;
        }

        .variant-option input[type="radio"]:checked~.variant-option {
            border-color: #b2dfdb;
            background: #e0f7fa;
        }

        .variant-option input[type="radio"]:checked {
            border-color: #b2dfdb;
            background-color: #e0f7fa;
        }

        .variant-option input[type="radio"]:focus {
            box-shadow: none;
        }

        .variant-option .form-check-input[type="radio"]:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .variant-option .form-check-input:checked~.variant-option {
            border-color: #007bff;
            background-color: #e3f2fd;
        }

        .variant-price {
            font-weight: 600;
            color: #28a745;
        }

        .variant-label {
            font-weight: 500;
        }

        .variants-container {
            max-height: 300px;
            overflow-y: auto;
        }

        /* Image Gallery Styles */
        .product-gallery {
            position: relative;
        }

        .main-image-container {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            cursor: pointer;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image {
            width: 100%;
            height: 600px;
            object-fit: contain;
            transition: transform 0.3s ease;
            background: #f8f9fa;
        }

        .main-image:hover {
            transform: scale(1.02);
        }

        .thumbnail-gallery {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .thumbnail-item {
            flex: 0 0 100px;
            height: 120px;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .thumbnail-item:hover {
            border-color: #007bff;
            transform: translateY(-2px);
        }

        .thumbnail-item.active {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }

        .thumbnail-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f8f9fa;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .main-image-container:hover .gallery-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .gallery-overlay i {
            color: white;
            font-size: 2rem;
        }

        /* Lightbox Styles */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: none;
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }

        .lightbox-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .lightbox-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .lightbox-nav:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .lightbox-prev {
            left: 20px;
        }

        .lightbox-next {
            right: 20px;
        }

        /* List View Styles */
        .list-view .related-product-item {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .list-view .product-card {
            flex-direction: row !important;
            height: auto !important;
        }

        .list-view .product-card .position-relative {
            width: 200px;
            flex-shrink: 0;
        }

        .list-view .product-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .list-view .product-card .card-img-top {
            height: 150px !important;
            object-fit: cover;
        }

        .list-view .product-card .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .list-view .product-card .card-text {
            margin-bottom: 1rem;
        }

        .list-view .product-card .mt-auto {
            margin-top: 0 !important;
        }

        .list-view .product-card .d-flex.gap-2 {
            justify-content: flex-start;
        }

        .list-view .product-card .btn {
            min-width: 100px;
        }
    </style>

    @php
        // Find similar products by title (80%+ similarity)
        $similarProducts = collect($allProducts ?? [])->filter(function ($p) use ($product) {
            if ($p->id === $product->id) {
                return false;
            }
            similar_text(strtolower($p->name), strtolower($product->name), $percent);
            return $percent >= 80;
        });
    @endphp
    <div class="container">
        <br>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name ?? 'Category' }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="product-gallery">
                    <!-- Main Image -->
                    <div class="main-image-container" id="mainImageContainer">
                        <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                            class="main-image" id="mainImage" alt="{{ $product->name }}">

                        <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>

                        @if ($product->is_featured)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-star"></i> Featured
                                </span>
                            </div>
                        @endif
                        @if ($product->status !== 'active')
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-secondary fs-6">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="thumbnail-gallery" id="thumbnailGallery">
                        @php
                            $galleryImages = [];
                            if ($product->gallery && is_array(json_decode($product->gallery, true))) {
                                $galleryImages = json_decode($product->gallery, true);
                            }
                        @endphp
                        <div class="thumbnail-item active" data-index="0">
                            <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                                alt="Product Image 1" class="thumbnail-image">
                        </div>
                        @foreach ($galleryImages as $i => $galleryImage)
                            <div class="thumbnail-item" data-index="{{ $i + 1 }}">
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Product Image {{ $i + 2 }}"
                                    class="thumbnail-image">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3 mb-3">{{ $product->name }}</h1>

                        <!-- Price -->
                        <div class="mb-3">
                            @if ($product->isWholesalerUser() && $product->hasBothPricingTypes())
                                <!-- Pricing Type Selection for Wholesalers -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select Pricing Type:</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="pricing_type" id="unit_pricing"
                                            value="unit" checked>
                                        <label class="btn btn-outline-primary" for="unit_pricing">
                                            Unit: {{ $product->getDisplayPrice('unit') }}
                                        </label>

                                        <input type="radio" class="btn-check" name="pricing_type" id="kit_pricing"
                                            value="kit">
                                        <label class="btn btn-outline-primary" for="kit_pricing">
                                            Kit: {{ $product->getDisplayPrice('kit') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="price fs-2" id="selectedPrice">
                                        {{ $product->getDisplayPrice('unit') }}
                                    </span>
                                </div>
                            @else
                                <span class="price fs-2">
                                    {{ $product->getDisplayPrice() }}
                                </span>
                            @endif
                        </div>

                        <!-- Product Meta -->
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-eye"></i> {{ $product->views ?? 0 }} views
                                <span class="mx-2">|</span>
                                <i class="bi bi-box"></i> SKU: {{ $product->sku }}
                                @if ($product->brand)
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-star"></i> {{ $product->brand->name }}
                                @endif
                            </small>
                        </div>

                        <!-- Stock Status -->
                        @if ($product->track_quantity)
                            <div class="mb-3">
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> In Stock ({{ $product->stock }} available)
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Out of Stock
                                    </span>
                                @endif
                            </div>
                        @endif

                        <br>
                        @foreach ($similarProducts as $p)
                            <a href="{{ route('products.show', $p) }}" class="btn btn-outline-danger btn-sm">
                                {{ $p->name }}
                            </a>
                        @endforeach
                        <br>
                        <br>
                        <!-- Description -->
                        <div class="mb-4">
                            <h6>Description</h6>
                            <p class="text-muted">{{ $product->description ?: 'No description available.' }}</p>
                        </div>

                        <!-- Product Variants -->
                        {{-- Variant selection removed: no variants in this store --}}

                        <!-- Add to Cart Form -->
                        <form id="add-to-cart-form" class="mb-4">
                            @if ($product->isWholesalerUser() && $product->hasBothPricingTypes())
                                <!-- Hidden input for pricing type -->
                                <input type="hidden" id="selected_pricing_type" name="pricing_type" value="unit">
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" value="1"
                                        min="1" max="{{ $product->track_quantity ? $product->stock : 999 }}">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100 btn-lg"
                                        {{ $product->track_quantity && $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Product Features -->
                        {{-- Features removed: not present in migration --}}

                        <!-- Share -->
                        @php
                            $productUrl = urlencode(request()->fullUrl());
                            $productName = urlencode($product->name ?? 'Check this product!');
                        @endphp
                        <div class="border-top pt-3">
                            <h6>Share this product</h6>
                            <div class="product-share-group">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $productUrl }}"
                                    class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">
                                    <i class="bi bi-facebook"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ $productUrl }}&text={{ $productName }}"
                                    class="btn btn-outline-info btn-sm" target="_blank" rel="noopener">
                                    <i class="bi bi-twitter"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ $productName }}%20{{ $productUrl }}"
                                    class="btn btn-outline-success btn-sm" target="_blank" rel="noopener">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->

        @if ($similarProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">
                            <i class="bi bi-grid"></i> Similar Products
                        </h3>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted">View:</span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm active" id="gridView">
                                    <i class="bi bi-grid"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="listView">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row" id="relatedProductsContainer">
                        @foreach ($similarProducts as $similarProduct)
                            <div class="col-md-6 col-lg-3 mb-4 related-product-item">
                                <x-product-card :product="$similarProduct" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close" id="lightboxClose">
                <i class="bi bi-x"></i>
            </button>
            <img src="" alt="" class="lightbox-image" id="lightboxImage">
            <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" id="lightboxNext">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Product gallery data
        const productGallery = {
            images: [
                '{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/600x400?text=No+Image' }}',
                @if ($product->gallery && is_array(json_decode($product->gallery, true)))
                    @foreach (json_decode($product->gallery, true) as $galleryImage)
                        '{{ asset('storage/' . $galleryImage) }}',
                    @endforeach
                @endif
            ],
            currentIndex: 0
        };

        // Initialize gallery on page load
        $(function() {
            initializeGallery();
            initializeVariantSelection();
            initializeLightbox();

            // Variant selection handling
            // No variants, nothing to initialize

            function initializeGallery() {
                // Already initialized above, so just build the thumbnail gallery
                buildThumbnailGallery();
            }

            function buildThumbnailGallery() {
                const thumbnailGallery = $('#thumbnailGallery');
                thumbnailGallery.empty();

                productGallery.images.forEach((image, index) => {
                    const thumbnailItem = $(`
                    <div class="thumbnail-item ${index === 0 ? 'active' : ''}" data-index="${index}">
                        <img src="${image}" alt="Product Image ${index + 1}" class="thumbnail-image">
                    </div>
                `);

                    thumbnailItem.on('click', function() {
                        setActiveImage(index);
                    });

                    thumbnailGallery.append(thumbnailItem);
                });
            }

            function setActiveImage(index) {
                productGallery.currentIndex = index;
                const imageUrl = productGallery.images[index];

                // Update main image
                $('#mainImage').attr('src', imageUrl);

                // Update thumbnail active state
                $('.thumbnail-item').removeClass('active');
                $(`.thumbnail-item[data-index="${index}"]`).addClass('active');
            }

            function initializeVariantSelection() {
                // No variants, nothing to initialize
            }

            // No updateVariantDisplay needed: no variants

            function initializeLightbox() {
                // Open lightbox on main image click
                $('#mainImageContainer').on('click', function() {
                    openLightbox(productGallery.currentIndex);
                });

                // Close lightbox
                $('#lightboxClose, #lightbox').on('click', function(e) {
                    if (e.target === this) {
                        closeLightbox();
                    }
                });

                // Navigation
                $('#lightboxPrev').on('click', function() {
                    navigateLightbox(-1);
                });

                $('#lightboxNext').on('click', function() {
                    navigateLightbox(1);
                });

                // Keyboard navigation
                $(document).on('keydown', function(e) {
                    if ($('#lightbox').hasClass('active')) {
                        switch (e.key) {
                            case 'Escape':
                                closeLightbox();
                                break;
                            case 'ArrowLeft':
                                navigateLightbox(-1);
                                break;
                            case 'ArrowRight':
                                navigateLightbox(1);
                                break;
                        }
                    }
                });
            }

            function openLightbox(index) {
                productGallery.currentIndex = index;
                const imageUrl = productGallery.images[index];

                $('#lightboxImage').attr('src', imageUrl);
                $('#lightbox').addClass('active');
                $('body').css('overflow', 'hidden');
            }

            function closeLightbox() {
                $('#lightbox').removeClass('active');
                $('body').css('overflow', '');
            }

            function navigateLightbox(direction) {
                let newIndex = productGallery.currentIndex + direction;

                if (newIndex < 0) {
                    newIndex = productGallery.images.length - 1;
                } else if (newIndex >= productGallery.images.length) {
                    newIndex = 0;
                }

                openLightbox(newIndex);
            }

            // Pricing type selection handling
            $(document).on('change', 'input[name="pricing_type"]', function() {
                const selectedType = $(this).val();
                const unitPrice = {{ $product->getUnitPrice() }};
                const kitPrice = {{ $product->getKitPrice() }};

                // Update displayed price
                const price = selectedType === 'unit' ? unitPrice : kitPrice;
                $('#selectedPrice').text('$' + price.toFixed(2));

                // Update hidden input
                $('#selected_pricing_type').val(selectedType);
            });

            // Add to cart form submission
            $(document).on('submit', '#add-to-cart-form', function(e) {
                e.preventDefault();

                const quantity = parseInt($('#quantity').val());
                const button = $(this).find('button[type="submit"]');
                const originalText = button.html();

                // Get selected pricing type for wholesalers
                const pricingType = $('#selected_pricing_type').val() || 'unit';

                // Show loading state
                button.html('Adding...');
                button.prop('disabled', true);

                // Add product to cart with pricing type
                addProductToCart(quantity, pricingType, button, originalText);
            });

            function addProductToCart(quantity, pricingType, button, originalText) {
                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        product_id: {{ $product->id }},
                        quantity: quantity,
                        pricing_type: pricingType
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('Product added to cart successfully!', 'success');
                            updateCartCount();
                        } else {
                            showToast(response.message, 'danger');
                        }
                        // Restore button state
                        button.html(originalText);
                        button.prop('disabled', false);
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response?.message || 'Failed to add product to cart', 'danger');
                        // Restore button state on error
                        button.html(originalText);
                        button.prop('disabled', false);
                    }
                });
            }

            // Add to cart function for related products
            window.addToCart = function(productId) {
                const button = event.target;
                const originalText = button.innerHTML;

                // Show loading state
                button.innerHTML = 'Adding...';
                button.disabled = true;

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: 1
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            updateCartCount();
                        } else {
                            showToast(response.message, 'danger');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast(response?.message || 'Failed to add product to cart', 'danger');
                    },
                    complete: function() {
                        // Restore button state
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                });
            };

            // Quantity validation
            $(document).on('input', '#quantity', function() {
                const value = parseInt($(this).val());
                const max = parseInt($(this).attr('max'));

                if (value > max) {
                    $(this).val(max);
                } else if (value < 1) {
                    $(this).val(1);
                }
            });

            // Grid/List View Toggle
            $(document).on('click', '#gridView, #listView', function() {
                const isGrid = $(this).attr('id') === 'gridView';
                const relatedProductsContainer = $('#relatedProductsContainer');

                if (isGrid) {
                    relatedProductsContainer.removeClass('list-view');
                    $('#gridView').addClass('active');
                    $('#listView').removeClass('active');
                } else {
                    relatedProductsContainer.addClass('list-view');
                    $('#listView').addClass('active');
                    $('#gridView').removeClass('active');
                }
            });
        });
    </script>
@endpush
