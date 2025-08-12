<form id="filterForm" method="GET" action="{{ route('products.index') }}">
    <div class="row g-3">
        <!-- Search -->
        {{-- <div class="col-12">
            <label for="search" class="form-label fw-medium text-secondary">
                <i class="bi bi-search me-1"></i>Search Products
            </label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" 
                       class="form-control border-start-0 ps-0" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name, description, or SKU...">
            </div>
        </div> --}}

        <!-- Category Filter -->
        <div class="col-12">
            <label for="category" class="form-label fw-medium text-secondary">
                <i class="bi bi-tag me-1"></i>Category
            </label>
            <select class="form-select" id="category" name="category">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Sort -->
        {{-- <div class="col-12">
            <label for="sort" class="form-label fw-medium text-secondary">
                <i class="bi bi-sort-down me-1"></i>Sort By
            </label>
            <select class="form-select" id="sort" name="sort">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price Low-High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
        </div> --}}

        <!-- Price Range -->
        <div class="col-12">
            <label class="form-label fw-medium text-secondary">
                <i class="bi bi-currency-dollar me-1"></i>Price Range
            </label>
            <div class="row g-2">
                <div class="col-6">
                    <input type="number" 
                           class="form-control" 
                           id="min_price" 
                           name="min_price" 
                           value="{{ request('min_price') }}"
                           placeholder="Min"
                           min="0">
                </div>
                <div class="col-6">
                    <input type="number" 
                           class="form-control" 
                           id="max_price" 
                           name="max_price" 
                           value="{{ request('max_price') }}"
                           placeholder="Max"
                           min="0">
                </div>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="col-12 pt-2">
            <div class="d-flex gap-2 w-100">
                <button type="submit" class="btn bg-primary text-white flex-fill">
                    <i class="bi bi-search me-2"></i>Apply Filters
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-2"></i>Clear
                </a>
            </div>
        </div>
    </div>
</form>

<style>
    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .input-group-text {
        border-radius: 8px 0 0 8px;
        border: 1px solid #e9ecef;
    }
    
    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-1px);
    }
</style> 