<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use App\Models\Traits\SelfHealingSlug;

class Product extends Model
{
    use SelfHealingSlug;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
    
        'thumbnail',
        'gallery',

 


        'status',
        'published_at',
        'tags',
   
        'variants',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_digital',
    ];

    protected $casts = [
        'gallery' => 'array',
        'tags' => 'array',
        'options' => 'array',
        'variants' => 'array',
        'published_at' => 'datetime',
        'has_variants' => 'boolean',
        'is_digital' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    

   

    /**
     * Get all variants as a collection
     */
    public function getVariantsCollection()
    {
        return collect($this->variants ?? []);
    }

    /**
     * Get a variant by SKU
     */
    public function getVariantBySku(string $sku)
    {
        return $this->getVariantsCollection()->firstWhere('sku', $sku);
    }

    /**
     * Add a new variant
     */
    public function addVariant(array $variant)
    {
        $variants = $this->getVariantsCollection()->push($variant)->all();
        $this->variants = $variants;
        $this->save();
    }

    /**
     * Update a variant by SKU
     */
    public function updateVariant(string $sku, array $data)
    {
        $variants = $this->getVariantsCollection()->map(function ($variant) use ($sku, $data) {
            if (isset($variant['sku']) && $variant['sku'] === $sku) {
                return array_merge($variant, $data);
            }
            return $variant;
        })->all();
        $this->variants = $variants;
        $this->save();
    }

    /**
     * Remove a variant by SKU
     */
    public function removeVariant(string $sku)
    {
        $variants = $this->getVariantsCollection()->reject(function ($variant) use ($sku) {
            return isset($variant['sku']) && $variant['sku'] === $sku;
        })->values()->all();
        $this->variants = $variants;
        $this->save();
    }

    /**
     * Get total stock (sum of all variants)
     */
    public function getStock(): int
    {
        return $this->getVariantsCollection()->sum('stock');
    }

    /**
     * Check if product has variants
     */
    public function hasVariants(): bool
    {
        return !empty($this->variants) && is_array($this->variants) && count($this->variants) > 0;
    }

    /**
     * Get minimum price from variants (retailer.unit_price)
     */
    public function getMinPrice(): float
    {
        if (!$this->hasVariants()) {
            return $this->price ?? 0;
        }
        
        return $this->getVariantsCollection()
            ->pluck('price.retailer.unit_price')
            ->filter()
            ->min() ?? 0;
    }

    /**
     * Get maximum price from variants (retailer.unit_price)
     */
    public function getMaxPrice(): float
    {
        if (!$this->hasVariants()) {
            return $this->price ?? 0;
        }
        
        return $this->getVariantsCollection()
            ->pluck('price.retailer.unit_price')
            ->filter()
            ->max() ?? 0;
    }

    /**
     * Get price range as string
     */
    public function getPriceRange(): string
    {
        $min = $this->getMinPrice();
        $max = $this->getMaxPrice();
        if ($min == $max) {
            return '$' . number_format($min, 2);
        }
        return '$' . number_format($min, 2) . ' - $' . number_format($max, 2);
    }

    /**
     * Get image URL for frontend display
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->thumbnail) {
            // If thumbnail is a full URL, return it directly
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }
            
            // If thumbnail is a local path, return the storage URL
            return asset('storage/' . $this->thumbnail);
        }
        
        // Return a placeholder image if no thumbnail
        return 'https://via.placeholder.com/300x200?text=No+Image';
    }

    /**
     * Get gallery images for frontend display
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }

        return array_map(function($image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            return asset('storage/' . $image);
        }, $this->gallery);
    }

    /**
     * Check if product is digital
     */
    public function isDigital(): bool
    {
        return false;
    }
}
