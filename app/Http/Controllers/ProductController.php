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
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
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

        $allProducts = Product::all();
        $product->increment('views');
        if ($product->is_digital) {
            // For now, just return the regular view since AudioBook model doesn't exist
            return view('frontend.products.show', compact('product',  'allProducts'));
        }

        // Default (physical) product view
        return view('frontend.products.show', compact('product', 'allProducts'));
    }
}
