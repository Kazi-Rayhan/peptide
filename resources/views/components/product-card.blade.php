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
        <h5 class="card-title fw-light mb-2 text-center" style="font-size: 14px;">{{ $product->name }}</h5>
        
        <!-- Price -->
        <div class="price mb-3 text-center h5 text-primary">
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
