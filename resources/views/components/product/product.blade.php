@props(['product'])

<div class="product-card h-100">
    <!-- Product Image Container -->
    <div class="product-image-container position-relative overflow-hidden">
        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300x300?text=Peptide' }}" 
             alt="{{ $product->name }}" 
             class="product-image w-100 h-100 object-fit-cover">
        
        <!-- Sale Badge -->
        @if($product->is_on_sale)
            <div class="sale-badge">
                <span>SALE</span>
            </div>
        @endif
        
        <!-- Quick Actions Overlay -->
        <div class="product-overlay">
            <div class="overlay-content">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-eye"></i> View
                </a>
                <button onclick="addToCart({{ $product->id }})" class="btn btn-primary btn-sm">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>
    
    <!-- Product Info -->
    <div class="product-info p-3">
        <!-- Product Name -->
        <h6 class="product-title mb-2">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                {{ $product->name }}
            </a>
        </h6>
        
        <!-- Product Description -->
        @if($product->description)
            <p class="product-description text-muted small mb-2">
                {{ Str::limit($product->description, 80) }}
            </p>
        @endif
        
        <!-- Price -->
        <div class="product-price mb-3">
            @if($product->hasVariants())
                @php
                    $minPrice = $product->getMinPrice();
                    $maxPrice = $product->getMaxPrice();
                @endphp
                @if($minPrice == $maxPrice)
                    <span class="current-price">${{ number_format($minPrice, 2) }}</span>
                @else
                    <span class="current-price">${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}</span>
                @endif
            @else
                @if($product->is_on_sale && $product->sale_price)
                    <span class="original-price text-muted text-decoration-line-through me-2">${{ number_format($product->price, 2) }}</span>
                    <span class="current-price text-danger">${{ number_format($product->sale_price, 2) }}</span>
                @else
                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
                @endif
            @endif
        </div>
        
        <!-- Add to Cart Button -->
        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary w-100 add-to-cart-btn">
            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
        </button>
    </div>
</div>

<style>
.product-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #f8f9fa;
    overflow: hidden;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    position: relative;
    height: 200px;
    background: #f8f9fa;
}

.product-image {
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.sale-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, #dc3545, #e74c3c);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 104, 122, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 3;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
}

.product-info {
    padding: 1.5rem;
}

.product-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.4;
    margin-bottom: 0.5rem;
}

.product-title a {
    color: #2c3e50;
    transition: color 0.3s ease;
}

.product-title a:hover {
    color: #00687a;
}

.product-description {
    font-size: 0.875rem;
    line-height: 1.5;
    color: #6c757d;
    margin-bottom: 1rem;
}

.product-price {
    margin-bottom: 1rem;
}

.current-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #00687a;
}

.original-price {
    font-size: 0.9rem;
    color: #6c757d;
}

.add-to-cart-btn {
    background: linear-gradient(45deg, #00687a, #00a3cc);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.add-to-cart-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.add-to-cart-btn:hover::before {
    left: 100%;
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 104, 122, 0.3);
}

/* Loading state for button */
.add-to-cart-btn.loading {
    pointer-events: none;
    position: relative;
}

.add-to-cart-btn.loading::after {
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

/* Mobile Responsive */
@media (max-width: 768px) {
    .product-image-container {
        height: 180px;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .product-title {
        font-size: 0.95rem;
    }
    
    .current-price {
        font-size: 1.1rem;
    }
    
    .add-to-cart-btn {
        padding: 0.6rem 0.8rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .product-image-container {
        height: 160px;
    }
    
    .product-info {
        padding: 0.75rem;
    }
    
    .product-title {
        font-size: 0.9rem;
    }
    
    .current-price {
        font-size: 1rem;
    }
}
</style>

<script>
function addToCart(productId) {
    const btn = event.target.closest('.add-to-cart-btn');
    const originalText = btn.innerHTML;
    // Add loading state
    btn.classList.add('loading');
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
            // Update cart count instantly on success
            const cartElements = document.querySelectorAll('#cart-count, #cart-count-mobile, #cart-count-offcanvas, .cart-badge');
            cartElements.forEach(el => {
                let current = parseInt(el.textContent, 10) || 0;
                el.textContent = current + 1;
            });
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
        btn.classList.remove('loading');
        btn.innerHTML = originalText;
    });
}

function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartElements = document.querySelectorAll('#cart-count, #cart-count-mobile, #cart-count-offcanvas, .cart-badge');
            cartElements.forEach(el => el.textContent = data.cart_count);
        })
        .catch(error => console.error('Error updating cart count:', error));
}

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
</script> 