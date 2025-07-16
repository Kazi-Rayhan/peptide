@props(['product'])
<div class=" ">
    <!-- Product Image -->
    <div class="position-relative">
        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300x300?text=Peptide' }}" 
             alt="{{ $product->name }}" 
             class="product-image w-100">
        @if($product->is_on_sale)
            <span class="badge bg-danger position-absolute top-0 end-0 m-2">SALE</span>
        @endif
    </div>
    
    <!-- Card Body -->
    <a style="text-decoration: none; color: inherit;" href="{{ route('products.show', $product) }}">
    <div class="card-body d-flex flex-column">
        <!-- Product Name -->
        <h5 class="card-title fw-light mb-2 text-center" >{{ $product->name }}</h5>
        
        <!-- Price -->
        <div class="price mb-3 text-center">
            @if($product->hasVariants())
                @php
                    $minPrice = $product->getMinPrice();
                    $maxPrice = $product->getMaxPrice();
                @endphp
                @if($minPrice == $maxPrice)
                    ${{ number_format($minPrice, 2) }}
                @else
                    ${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}
                @endif
            @else
                ${{ number_format($product->price, 2) }}
            @endif
        </div>
    </div>
    </a>
</div>

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
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count || 0;
            }
            
            // Show success message
            showToast('Product added to cart successfully!', 'success');
        } else {
            showToast(data.message || 'Error adding product to cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding product to cart', 'danger');
    });
}

function showToast(message, type = 'success') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
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
</script> 