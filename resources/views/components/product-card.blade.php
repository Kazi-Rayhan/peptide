@props(['product'])
<div class=" ">
    <a href="{{ route('products.show', $product) }}">
    <!-- Product Image -->
    <div class="position-relative">
        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300x300?text=Peptide' }}" 
             alt="{{ $product->name }}" 
             class="product-image w-100">
      
    </div>
    
    <!-- Card Body -->
    <a style="text-decoration: none; color: inherit;" href="{{ route('products.show', $product) }}">
    <div class="card-body d-flex flex-column">
        <!-- Product Name -->
        <h5 class="card-title fw-light mb-2 text-center" style="font-size: 16px; color: #1d1d1d;">{{ $product->name }}</h5>
        
        <!-- Price -->
        <div class=" mb-3 text-center h4 fw-bold" style="color: #232dbe;">
            @if($product->isWholesalerUser() && $product->hasBothPricingTypes())
                <div class="small text-muted mb-1">From {{ $product->getDisplayPrice() }}</div>
                <div class="small">
                    <span class="badge bg-primary me-1">Unit</span>
                    <span class="badge bg-success">Kit</span>
                </div>
            @else
                ${{ number_format($product->getPrice(), 2) }}
            @endif
        </div>
    </div>
    </a>
</div>
