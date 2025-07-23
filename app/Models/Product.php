<?php

namespace App\Models;

use App\Enums\Level;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use App\Models\Traits\SelfHealingSlug;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SelfHealingSlug;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'tax_class_id',
        'price',
        'sale_price',
        'is_featured',
        'thumbnail',
        'status',
        'stock',
        'track_quantity',
        'attributes',
        'meta_title',
        'meta_description',
        'meta_keywords',

    ];

    protected $casts = [
        'price' => 'array',
        'attributes' => 'array',
    ];

    // protected $attributes = [
    //     'is_active' => true,
    //     'is_featured' => false,
    //     'is_on_sale' => false,
    //     'price' => 0.00,
    //     'sale_price' => 0.00,
    // ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function taxClass()
    {
        return $this->belongsTo(\App\Models\TaxClass::class);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    protected function currnetLevel()
    {
        if(Auth::check()){
            return Auth::user()->current_level->value;
        }
        return Level::RETAILER->value;
    }

    /**
     * Get price for specific type (unit or kit)
     */
    public function getPrice($type = 'unit')
    {
        $level = $this->currnetLevel();
        
        if (!isset($this->price[$level])) {
            return 0;
        }
        
        if($type == 'unit'){
            return $this->price[$level]['unit_price'] ?? 0;
        }else{
            return $this->price[$level]['kit_price'] ?? 0;
        }
    }

    /**
     * Check if product has both unit and kit pricing for current user level
     */
    public function hasBothPricingTypes(): bool
    {
        $level = $this->currnetLevel();
        
        if (!isset($this->price[$level])) {
            return false;
        }
        
        return isset($this->price[$level]['unit_price']) && 
               isset($this->price[$level]['kit_price']) && 
               $this->price[$level]['unit_price'] > 0 && 
               $this->price[$level]['kit_price'] > 0;
    }

    /**
     * Check if current user is a wholesaler
     */
    public function isWholesalerUser(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        $user = Auth::user();
        return $user->is_wholesaler || 
               in_array($user->current_level->value, [
                   Level::WHOLESALER_ONE->value,
                   Level::WHOLESALER_TWO->value,
                   Level::DISTRIBUTOR_ONE->value,
                   Level::DISTRIBUTOR_TWO->value
               ]);
    }

    /**
     * Get unit price for current user level
     */
    public function getUnitPrice()
    {
        return $this->getPrice('unit');
    }

    /**
     * Get kit price for current user level
     */
    public function getKitPrice()
    {
        return $this->getPrice('kit');
    }

    /**
     * Get minimum price between unit and kit for current user level
     */
    public function getMinPrice()
    {
        $unitPrice = $this->getUnitPrice();
        $kitPrice = $this->getKitPrice();
        
        if ($unitPrice == 0 && $kitPrice == 0) {
            return 0;
        }
        
        if ($unitPrice == 0) {
            return $kitPrice;
        }
        
        if ($kitPrice == 0) {
            return $unitPrice;
        }
        
        return min($unitPrice, $kitPrice);
    }

    /**
     * Get maximum price between unit and kit for current user level
     */
    public function getMaxPrice()
    {
        $unitPrice = $this->getUnitPrice();
        $kitPrice = $this->getKitPrice();
        
        return max($unitPrice, $kitPrice);
    }

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
     * Get display price based on selected type
     */
    public function getDisplayPrice($type = 'unit'): string
    {
        $price = $this->getPrice($type);
        return '$' . number_format($price, 2);
    }

    /*
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
}
