<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * CartService - Modern Shopping Cart Implementation
 * 
 * Features:
 * - Session-based cart for guests
 * - Database storage for logged-in users
 * - Abandoned cart tracking
 * - Coupon/discount support
 * - Tax calculation
 * - Shipping calculation
 * - Easy frontend integration
 * - Cart expiration management
 * 
 * @package App\Services
 */
class CartService
{
    protected $cartId;
    protected $user;
    protected $cart;
    protected $items = [];
    protected $coupons = [];
    protected $taxRate = 0;
    protected $shippingCost = 0;
    protected $abandonedCartThreshold = 24; // hours

    public function __construct()
    {
        $this->user = Auth::user();
        $this->initializeCart();
    }

    /**
     * Initialize cart from session or database
     */
    protected function initializeCart()
    {
        if ($this->user) {
            // Logged in user - use database
            $this->initializeDatabaseCart();
        } else {
            // Guest user - use session
            $this->initializeSessionCart();
        }
    }

    /**
     * Initialize cart for logged-in users
     */
    protected function initializeDatabaseCart()
    {
        $this->cart = Cart::where('user_id', $this->user->id)
            ->where('status', 'active')
            ->first();

        if (!$this->cart) {
            $this->cart = Cart::create([
                'user_id' => $this->user->id,
                'cart_id' => Str::uuid(),
                'status' => 'active',
                'expires_at' => Carbon::now()->addDays(30),
            ]);
        }

        $this->cartId = $this->cart->cart_id;
        $this->loadCartItems();
    }

    /**
     * Initialize cart for guest users
     */
    protected function initializeSessionCart()
    {
        $this->cartId = Session::get('cart_id');
        
        if (!$this->cartId) {
            $this->cartId = Str::uuid();
            Session::put('cart_id', $this->cartId);
        }

        $this->items = Session::get("cart_items_{$this->cartId}", []);
        $this->coupons = Session::get("cart_coupons_{$this->cartId}", []);
        
        // Debug logging
        Log::info('Cart initialized', [
            'cart_id' => $this->cartId,
            'items_count' => count($this->items),
            'coupons_count' => count($this->coupons),
            'session_id' => Session::getId(),
        ]);
    }

    /**
     * Load cart items from database
     */
    protected function loadCartItems()
    {
        if ($this->cart) {
            $this->items = [];
            
            foreach ($this->cart->items as $item) {
                // Create unique key based on product and variant
                $itemKey = $this->getItemKey($item->product_id, $item->options ?? [], $item->variant, $item->pricing_type);
                
                $this->items[$itemKey] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'sku' => $item->sku,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'variant' => $item->variant,
                    'options' => $item->options ?? [],
                    'pricing_type' => $item->pricing_type,
                    'total' => $item->total,
                    'image_url' => $item->product->image_url ?? null,
                    'added_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            }
            
            // Load coupons from database
            if ($this->cart->coupon_code && $this->cart->coupon_data) {
                $this->coupons[$this->cart->coupon_code] = $this->cart->coupon_data;
            }
        }
    }

    /**
     * Add product to cart
     * 
     * @param int $productId
     * @param int $quantity
     * @param array $options
     * @param array|null $variantData
     * @param string|null $pricingType
     * @return array
     */
    public function add($productId, $quantity = 1, $options = [], $variantData = null, $pricingType = null)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        $sku = $product->sku;
        
        // Get price based on pricing type for wholesalers
        if ($pricingType && method_exists($product, 'getPrice')) {
            $price = $product->getPrice($pricingType);
        } else {
            $price = method_exists($product, 'getPrice') ? $product->getPrice() : (is_array($product->price) ? ($product->price['retail'] ?? $product->price[0] ?? $product->price) : (is_numeric($product->price) ? $product->price : 0));
        }
        
        $productName = $product->name;

        // Check stock
        if ($product->track_quantity && $product->stock < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }

        // Create unique item key (include pricing type for wholesalers)
        $itemKey = $this->getItemKey($productId, $options, $variantData, $pricingType);
        
        if (isset($this->items[$itemKey])) {
            $this->items[$itemKey]['quantity'] += $quantity;
            $this->items[$itemKey]['total'] = $price * $this->items[$itemKey]['quantity'];
            $this->items[$itemKey]['image_url'] = $product->image_url;
        } else {
            $this->items[$itemKey] = [
                'product_id' => $productId,
                'product_name' => $productName,
                'sku' => $sku,
                'price' => $price,
                'quantity' => $quantity,
                'variant' => $variantData,
                'options' => $options,
                'pricing_type' => $pricingType,
                'total' => $price * $quantity,
                'image_url' => $product->image_url,
                'added_at' => Carbon::now(),
            ];
        }

        $this->saveCart();
        
        return [
            'success' => true, 
            'message' => 'Product added to cart',
            'cart_count' => $this->getItemCount(),
            'cart_total' => $this->getSubtotal()
        ];
    }

    /**
     * Update product quantity
     * 
     * @param int $productId
     * @param int $quantity
     * @param array $options
     * @return array
     */
    public function update($productId, $quantity, $options = [])
    {
        $itemKey = $this->getItemKey($productId, $options);
        
        if (!isset($this->items[$itemKey])) {
            return ['success' => false, 'message' => 'Item not found in cart'];
        }

        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        if ($quantity <= 0) {
            return $this->remove($productId, $options);
        }
        // Check stock
        if ($product->track_quantity && $product->stock < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }

        $this->items[$itemKey]['quantity'] = $quantity;
        $this->items[$itemKey]['total'] = $this->items[$itemKey]['price'] * $quantity;
        $this->items[$itemKey]['updated_at'] = Carbon::now();

        $this->saveCart();
        
        return [
            'success' => true, 
            'message' => 'Cart updated',
            'cart_count' => $this->getItemCount(),
            'cart_total' => $this->getSubtotal(),
            'item_total' => $this->items[$itemKey]['total']
        ];
    }

    /**
     * Update cart item by item ID
     * 
     * @param string $itemId
     * @param int $quantity
     * @return array
     */
    public function updateByItemId($itemId, $quantity)
    {
        if (!isset($this->items[$itemId])) {
            return ['success' => false, 'message' => 'Item not found in cart'];
        }

        $item = $this->items[$itemId];
        $product = Product::find($item['product_id']);
        
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        if ($quantity <= 0) {
            return $this->removeByItemId($itemId);
        }
        // Check stock
        if ($product->track_quantity && $product->stock < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }

        $this->items[$itemId]['quantity'] = $quantity;
        $this->items[$itemId]['total'] = $this->items[$itemId]['price'] * $quantity;
        $this->items[$itemId]['updated_at'] = Carbon::now();

        $this->saveCart();
        
        return [
            'success' => true, 
            'message' => 'Cart updated',
            'cart_count' => $this->getItemCount(),
            'cart_total' => $this->getSubtotal(),
            'item_total' => $this->items[$itemId]['total']
        ];
    }

    /**
     * Remove product from cart
     * 
     * @param int $productId
     * @param array $options
     * @param array|null $variant
     * @return array
     */
    public function remove($productId, $options = [], $variant = null)
    {
        $itemKey = $this->getItemKey($productId, $options, $variant);
        
        if (isset($this->items[$itemKey])) {
            unset($this->items[$itemKey]);
            $this->saveCart();
        }
        
        return [
            'success' => true, 
            'message' => 'Product removed from cart',
            'cart_count' => $this->getItemCount(),
            'cart_total' => $this->getSubtotal()
        ];
    }

    /**
     * Remove cart item by item ID
     * 
     * @param string $itemId
     * @return array
     */
    public function removeByItemId($itemId)
    {
        if (isset($this->items[$itemId])) {
            unset($this->items[$itemId]);
            $this->saveCart();
        }
        
        return [
            'success' => true, 
            'message' => 'Product removed from cart',
            'cart_count' => $this->getItemCount(),
            'cart_total' => $this->getSubtotal()
        ];
    }

    /**
     * Clear entire cart
     * 
     * @return array
     */
    public function clear()
    {
        $this->items = [];
        $this->coupons = [];
        $this->saveCart();
        
        return [
            'success' => true, 
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'cart_total' => 0
        ];
    }

    /**
     * Get cart items
     * 
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get cart item count
     * 
     * @return int
     */
    public function getItemCount()
    {
        return array_sum(array_column($this->items, 'quantity'));
    }

    /**
     * Get cart subtotal
     * 
     * @return float
     */
    public function getSubtotal()
    {
        return array_sum(array_column($this->items, 'total'));
    }

    /**
     * Get cart total with tax and shipping
     * 
     * @return float
     */
    public function getTotal()
    {
        $subtotal = $this->getSubtotal();
        $discount = $this->getDiscountTotal();
        $tax = $this->getTaxAmount();
        $shipping = $this->getShippingCost();
        
        return $subtotal - $discount + $tax + $shipping;
    }

    /**
     * Add coupon to cart
     * 
     * @param string $code
     * @return array
     */
    public function addCoupon($code)
    {
        // Implement coupon logic here
        $coupon = \App\Models\Coupon::where('code', $code)
            ->where('is_active', true)
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now())
            ->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code'];
        }

        // Check if coupon has reached max uses
        if ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
            return ['success' => false, 'message' => 'Coupon has reached maximum usage limit'];
        }

        // Check minimum order amount
        if ($coupon->min_order && $this->getSubtotal() < $coupon->min_order) {
            return ['success' => false, 'message' => 'Minimum order amount of $' . $coupon->min_order . ' required for this coupon'];
        }

        $this->coupons[$code] = $coupon;
        $this->saveCart();
        
        // Debug logging
        Log::info('Coupon applied', [
            'code' => $code,
            'coupons_count' => count($this->coupons),
            'cart_id' => $this->cartId,
        ]);
        
        return ['success' => true, 'message' => 'Coupon applied successfully'];
    }

    /**
     * Remove coupon from cart
     * 
     * @param string|null $code
     * @return array
     */
    public function removeCoupon($code = null)
    {
        if ($code === null) {
            // Remove all coupons
            $this->coupons = [];
            $this->saveCart();
            return ['success' => true, 'message' => 'All coupons removed'];
        } else {
            // Remove specific coupon
            if (isset($this->coupons[$code])) {
                unset($this->coupons[$code]);
                $this->saveCart();
            }
            return ['success' => true, 'message' => 'Coupon removed'];
        }
    }

    /**
     * Get discount total
     * 
     * @return float
     */
    public function getDiscountTotal()
    {
        $total = 0;
        foreach ($this->coupons as $coupon) {
             $coupon = json_decode($coupon);
            if ($coupon->type === 'percent') {
                $total += ($this->getSubtotal() * $coupon->value / 100);
            } else {
                $total += $coupon->value;
            }
        }
        return $total;
    }

    /**
     * Get discount total (alias for getDiscountTotal)
     * 
     * @return float
     */
    public function getDiscount()
    {
        return $this->getDiscountTotal();
    }

    /**
     * Set tax rate
     * 
     * @param float $rate
     */
    public function setTaxRate($rate)
    {
        $this->taxRate = $rate;
    }

    /**
     * Calculate tax for the cart based on billing country and state
     *
     * @param int|null $countryId
     * @param int|null $stateId
     * @return float
     */
    public function calculateTax($countryId = null, $stateId = null)
    {
        $taxTotal = 0;
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || !$product->tax_class_id) {
                continue;
            }
            $taxClass = $product->taxClass;
            
            $rate = 0;
            if ($taxClass) {
                $taxRateQuery = $taxClass->taxRates();
                if ($countryId) {
                    $taxRateQuery->where('country_id', $countryId);
                }
                if ($stateId) {
                    $taxRateQuery->where('state_id', $stateId);
                }
                $taxRate = $taxRateQuery->first();
                if ($taxRate) {
                    $rate = $taxRate->rate;
                } elseif ($taxClass->rate !== null) {
                    $rate = $taxClass->rate;
                }
            }
            // If no rate found, use 0
            $lineTax = ($item['total'] - 0) * ($rate / 100);
            $taxTotal += $lineTax;
        }
        return $taxTotal;
    }

    /**
     * Calculate shipping for the cart based on shipping country and state
     *
     * @param int|null $countryId
     * @param int|null $stateId
     * @param int|null $storeShippingMethodId
     * @return float
     */
    public function calculateShipping($countryId = null, $stateId = null, $storeShippingMethodId = null)
    {
        $shippingRates = [];
        if ($countryId) {
            // Find all shipping zones that include this country
            $zones = \App\Models\ShippingZone::whereHas('countries', function($q) use ($countryId) {
                $q->where('countries.id', $countryId);
            })->get();
            foreach ($zones as $zone) {
                foreach ($zone->shippingMethods as $method) {
                    $shippingRates[] = $method->rate;
                }
            }
        }
        // Use the lowest rate if any found
        if (count($shippingRates) > 0) {
            return min($shippingRates);
        }
        // Fallback to StoreSettings shipping_method_id
        if ($storeShippingMethodId) {
            $method = \App\Models\ShippingMethod::find($storeShippingMethodId);
            if ($method) {
                return $method->rate;
            }
        }
        // If still not found, return 0
        return 0;
    }

    /**
     * Get tax amount (overrides previous logic)
     *
     * @param int|null $countryId
     * @param int|null $stateId
     * @return float
     */
    public function getTaxAmount($countryId = null, $stateId = null)
    {
        if ($countryId) {
            return $this->calculateTax($countryId, $stateId);
        }
        // fallback to old logic if no country provided
        $subtotal = $this->getSubtotal();
        $discount = $this->getDiscountTotal();
        return ($subtotal - $discount) * ($this->taxRate / 100);
    }

    /**
     * Get tax amount (alias for getTaxAmount)
     * 
     * @return float
     */
    public function getTax()
    {
        return $this->getTaxAmount();
    }

    /**
     * Set shipping cost
     * 
     * @param float $cost
     */
    public function setShippingCost($cost)
    {
        $this->shippingCost = $cost;
    }

    /**
     * Get shipping cost (overrides previous logic)
     *
     * @param int|null $countryId
     * @param int|null $stateId
     * @param int|null $storeShippingMethodId
     * @return float
     */
    public function getShippingCost($countryId = null, $stateId = null, $storeShippingMethodId = null)
    {
        if ($countryId) {
            return $this->calculateShipping($countryId, $stateId, $storeShippingMethodId);
        }
        return $this->shippingCost;
    }

    /**
     * Get shipping cost (alias for getShippingCost)
     * 
     * @return float
     */
    public function getShipping()
    {
        return $this->getShippingCost();
    }

    /**
     * Get cart summary
     * 
     * @return array
     */
    public function getSummary()
    {
        return [
            'items' => $this->getItems(),
            'item_count' => $this->getItemCount(),
            'subtotal' => $this->getSubtotal(),
            'discount' => $this->getDiscountTotal(),
            'tax' => $this->getTaxAmount(),
            'shipping' => $this->getShippingCost(),
            'total' => $this->getTotal(),
            'coupons' => $this->coupons,
        ];
    }

    /**
     * Get cart object
     * 
     * @return Cart|null
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Get coupon data
     * 
     * @return array|null
     */
    public function getCoupon()
    {
        return !empty($this->coupons) ? reset($this->coupons) : null;
    }

    /**
     * Apply coupon to cart
     * 
     * @param string $code
     * @return array
     */
    public function applyCoupon($code)
    {
        
        return $this->addCoupon($code);
    }



    /**
     * Save cart to session or database
     */
    protected function saveCart()
    {
        if ($this->user && $this->cart) {
            
            $this->saveToDatabase();
        } else {
            $this->saveToSession();
        }
    }

    /**
     * Save cart to database
     */
    protected function saveToDatabase()
    {
        // Clear existing items
        $this->cart->items()->delete();
        
        // Add new items
        foreach ($this->items as $item) {
            $this->cart->items()->create([
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'options' => $item['options'] ?? [],
                'pricing_type' => $item['pricing_type'] ?? null,
                'variant' => $item['variant'] ?? null,
                'variant_sku' => $item['variant']['sku'] ?? null,
                'total' => $item['total'],
            ]);
        }
        
        // Get coupon data
        $couponCode = null;
        $couponData = null;
        
        if (!empty($this->coupons)) {
            $couponCode = array_keys($this->coupons)[0];
            $couponData = $this->coupons[$couponCode];
        }

        
        // Update cart
        $this->cart->update([
            'subtotal' => $this->getSubtotal(),
            'discount' => $this->getDiscountTotal(),
            'total' => $this->getTotal(),
            'coupon_code' => $couponCode,
            'coupon_data' => $couponData,
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Save cart to session
     */
    protected function saveToSession()
    {
        Session::put("cart_items_{$this->cartId}", $this->items);
        Session::put("cart_coupons_{$this->cartId}", $this->coupons);
        
        // Ensure session is saved
        Session::save();
        
        // Debug logging
        Log::info('Cart saved to session', [
            'cart_id' => $this->cartId,
            'items_count' => count($this->items),
            'coupons_count' => count($this->coupons),
            'session_id' => Session::getId(),
        ]);
    }

    /**
     * Get unique item key
     * 
     * @param int $productId
     * @param array $options
     * @param array|null $variant
     * @return string
     */
    protected function getItemKey($productId, $options = [], $variant = null, $pricingType = null)
    {
        $key = $productId . '_' . md5(serialize($options));
        
        if ($variant) {
            $key .= '_' . md5(serialize($variant));
        }
        
        if ($pricingType) {
            $key .= '_' . $pricingType;
        }
        
        return $key;
    }

    /**
     * Merge guest cart with user cart on login
     * 
     * @param User $user
     */
    public static function mergeGuestCart(User $user)
    {
        $guestCartId = Session::get('cart_id');
        $guestItems = Session::get("cart_items_{$guestCartId}", []);
        
        if (empty($guestItems)) {
            return;
        }

        $userCart = Cart::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$userCart) {
            $userCart = Cart::create([
                'user_id' => $user->id,
                'cart_id' => Str::uuid(),
                'status' => 'active',
                'expires_at' => Carbon::now()->addDays(30),
            ]);
        }

        // Merge items
        foreach ($guestItems as $item) {
            // Create unique key for comparison
            $itemKey = $item['product_id'] . '_' . md5(serialize($item['options'] ?? []));
            
            $existingItem = $userCart->items()
                ->where('product_id', $item['product_id'])
                ->where('variant_sku', $item['variant']['sku'] ?? null)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $item['quantity'],
                    'total' => $existingItem->price * ($existingItem->quantity + $item['quantity']),
                ]);
            } else {
                $userCart->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'sku' => $item['sku'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'options' => $item['options'] ?? [],
                    'pricing_type' => $item['pricing_type'] ?? null,
                    'variant' => $item['variant'] ?? null,
                    'variant_sku' => $item['variant']['sku'] ?? null,
                    'total' => $item['total'],
                ]);
            }
        }

        // Clear guest cart
        Session::forget("cart_items_{$guestCartId}");
        Session::forget('cart_id');
    }

    /**
     * Track abandoned carts
     */
    public static function trackAbandonedCarts()
    {
        $threshold = Carbon::now()->subHours(24);
        
        $abandonedCarts = Cart::where('status', 'active')
            ->where('updated_at', '<', $threshold)
            ->get();

        foreach ($abandonedCarts as $cart) {
            $cart->update(['status' => 'abandoned']);
            
            // Send abandoned cart email
            if ($cart->user) {
                // Implement email notification
                // Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));
            }
        }
    }

    /**
     * Get abandoned carts
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAbandonedCarts()
    {
        return Cart::where('status', 'abandoned')
            ->with(['user', 'items.product'])
            ->get();
    }

    /**
     * Restore abandoned cart
     * 
     * @param string $cartId
     * @return bool
     */
    public static function restoreAbandonedCart($cartId)
    {
        $cart = Cart::where('cart_id', $cartId)
            ->where('status', 'abandoned')
            ->first();

        if ($cart) {
            $cart->update(['status' => 'active']);
            return true;
        }

        return false;
    }

    /**
     * Clean expired carts
     */
    public static function cleanExpiredCarts()
    {
        Cart::where('expires_at', '<', Carbon::now())
            ->where('status', 'active')
            ->update(['status' => 'expired']);
    }

    /**
     * Find variant by options
     * 
     * @param Product $product
     * @param array $options
     * @return array|null
     */
    protected function findVariant($product, $options)
    {
        return null;
    }

    /**
     * Check if variant matches the given options
     * 
     * @param array $variant
     * @param array $options
     * @return bool
     */
    protected function variantMatchesOptions($variant, $options)
    {
        // Check if variant has the required options
        foreach ($options as $key => $value) {
            if (!isset($variant[$key]) || $variant[$key] !== $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Format variant name for display
     * 
     * @param array $variant
     * @return string
     */
    protected function formatVariantName($variant)
    {
        // Check for strength attribute first
        if (isset($variant['attributes']) && is_array($variant['attributes']) && count($variant['attributes']) > 0) {
            return $variant['attributes'][0]['value'] ?? $variant['name'];
        }
        
        // Check for name field
        if (isset($variant['name'])) {
            return $variant['name'];
        }
        
        // Check for SKU if no other attributes found
        if (isset($variant['sku'])) {
            return 'SKU: ' . $variant['sku'];
        }
        
        return 'Variant';
    }

    /**
     * Get available variants for a product
     * 
     * @param int $productId
     * @return array
     */
    public function getProductVariants($productId)
    {
        return [];
    }

    /**
     * Get variant by SKU
     * 
     * @param int $productId
     * @param string $sku
     * @return array|null
     */
    public function getVariantBySku($productId, $sku)
    {
        return null;
    }

    /**
     * Add product by variant SKU
     * 
     * @param int $productId
     * @param string $variantSku
     * @param int $quantity
     * @return array
     */
    public function addByVariantSku($productId, $variantSku, $quantity = 1)
    {
        return ['success' => false, 'message' => 'Variants not supported'];
    }

    /**
     * Convert cart items to order lines format
     * 
     * @return array
     */
    public function toOrderLines()
    {
        $orderLines = [];
        foreach ($this->items as $item) {
            $orderLines[] = [
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'variant' => null,
                'notes' => null,
            ];
        }
        return $orderLines;
    }

    /**
     * Check if cart has items
     * 
     * @return bool
     */
    public function hasItems()
    {
        return !empty($this->items);
    }

    /**
     * Get cart items with product information
     * 
     * @return array
     */
    public function getItemsWithProducts()
    {
        $items = $this->getItems();
        $productIds = array_column($items, 'product_id');
        
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        foreach ($items as &$item) {
            $item['product'] = $products->get($item['product_id']);
        }
        
        return $items;
    }
} 