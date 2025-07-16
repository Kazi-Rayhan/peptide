<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category'])->where('status', 'active');

        // Filter by category (by slug only)
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sort = $request->get('sort', 'name');
        
        // Handle sorting with _desc suffix
        if (str_ends_with($sort, '_desc')) {
            $sort = str_replace('_desc', '', $sort);
            $direction = 'desc';
        } else {
            $direction = 'asc';
        }
        
        switch ($sort) {
            case 'price':
                $query->orderBy('price', $direction);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'name':
            default:
                $query->orderBy('name', $direction);
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        // Get current category for display
        $currentCategory = null;
        if ($request->has('category') && $request->category) {
            $currentCategory = Category::where('slug', $request->category)->first();
        }

        return view('frontend.products.index', compact('products', 'categories', 'currentCategory'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        // Get related products - first try same category and brand, then same category, then same brand
        $relatedProducts = Product::where('status', 'active')
            ->where('id', '!=', $product->id) // Exclude current product
            ->where(function($query) use ($product) {
                $query->where(function($q) use ($product) {
                    // Same category and brand
                    $q->where('category_id', $product->category_id);
                });
            })
            ->limit(4)
            ->get();

        // If we don't have enough related products, get more from the same category
        if ($relatedProducts->count() < 4) {
            $additionalProducts = Product::where('status', 'active')
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->where('category_id', $product->category_id)
                ->limit(4 - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        // If still not enough, get random products
        if ($relatedProducts->count() < 4) {
            $randomProducts = Product::where('status', 'active')
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit(4 - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($randomProducts);
        }

        // Prepare variants data for the view
        $variants = [];
        if ($product->hasVariants() && !empty($product->variants)) {
            foreach ($product->variants as $variant) {
                $variants[] = [
                    'sku' => $variant['sku'],
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'] ?? 0,
                    'thumbnail' => $variant['thumbnail'] ?? null,
                    'attributes' => $variant['attributes'] ?? [],
                    'label' => $variant['attributes'][0]['value'] ?? $variant['name'],
                ];
            }
        }

        // If product is digital, return a different view
        if ($product->is_digital) {
            // For now, just return the regular view since AudioBook model doesn't exist
            return view('frontend.products.show', compact('product', 'relatedProducts', 'variants'));
        }

        // Default (physical) product view
        return view('frontend.products.show', compact('product', 'relatedProducts', 'variants'));
    }
} 