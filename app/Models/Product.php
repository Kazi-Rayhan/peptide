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



    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }







    public function getPrice($type = 'unit')
    {
        if($type == 'unit'){
            return $this->price['wholesale_1']['unit_price'];
        }else{
            return $this->price['wholesale_1']['kit_price'];
        }
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
