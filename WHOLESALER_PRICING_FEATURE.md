# Wholesaler Unit/Kit Pricing Feature

## Overview
This feature allows wholesalers to choose between unit and kit pricing when purchasing products. The system automatically detects if a product has both pricing types available and shows the appropriate selection interface.

## Features Implemented

### 1. Product Model Enhancements (`app/Models/Product.php`)
- **`hasBothPricingTypes()`**: Checks if product has both unit and kit pricing for current user level
- **`isWholesalerUser()`**: Determines if current user is a wholesaler
- **`getUnitPrice()`**: Gets unit price for current user level
- **`getKitPrice()`**: Gets kit price for current user level
- **`getMinPrice()`**: Gets minimum price between unit and kit
- **`getMaxPrice()`**: Gets maximum price between unit and kit
- **`getDisplayPrice($type)`**: Gets formatted price string for display

### 2. Product Show Page (`resources/views/frontend/products/show.blade.php`)
- **Pricing Type Selection**: Radio buttons for wholesalers to choose between unit and kit pricing
- **Dynamic Price Display**: Shows selected pricing type with real-time updates
- **Hidden Input**: Stores selected pricing type for form submission

### 3. Cart Integration
- **CartController**: Updated to handle `pricing_type` parameter
- **CartService**: Enhanced to store and retrieve pricing type information
- **Database**: Added `pricing_type` column to `cart_items` table
- **Cart Display**: Shows pricing type in cart items

### 4. Product Cards (`resources/views/components/product-card.blade.php`)
- **Pricing Indicators**: Shows badges for unit/kit availability
- **Price Range**: Displays "From $X.XX" for products with multiple pricing types

## Database Changes

### Migration: `add_pricing_type_to_cart_items_table`
```php
$table->string('pricing_type')->nullable()->after('options'); // unit or kit
```

### CartItem Model
- Added `pricing_type` to fillable array

## Usage

### For Wholesalers
1. **Product Page**: When viewing a product with both unit and kit pricing, wholesalers see:
   - Radio buttons to select pricing type (Unit/Kit)
   - Dynamic price display that updates based on selection
   - Clear indication of both pricing options

2. **Cart**: 
   - Selected pricing type is stored with cart items
   - Cart displays pricing type for each item
   - Separate cart items for different pricing types of same product

3. **Product Cards**:
   - Shows "From $X.XX" for products with multiple pricing types
   - Displays badges indicating unit/kit availability

### For Retailers
- No changes to existing functionality
- Only sees default pricing (unit price)
- No pricing type selection interface

## Pricing Structure

The system expects product pricing in this format:
```php
[
    'retailer' => [
        'unit_price' => 15.00
    ],
    'wholesaler_1' => [
        'unit_price' => 10.00,
        'kit_price' => 25.00
    ],
    'wholesaler_2' => [
        'unit_price' => 8.00,
        'kit_price' => 20.00
    ]
]
```

## JavaScript Functionality

### Price Selection
```javascript
// Updates displayed price when pricing type changes
$(document).on('change', 'input[name="pricing_type"]', function() {
    const selectedType = $(this).val();
    const unitPrice = {{ $product->getUnitPrice() }};
    const kitPrice = {{ $product->getKitPrice() }};
    
    const price = selectedType === 'unit' ? unitPrice : kitPrice;
    $('#selectedPrice').text('$' + price.toFixed(2));
    $('#selected_pricing_type').val(selectedType);
});
```

### Cart Addition
```javascript
// Sends pricing type with cart addition request
function addProductToCart(quantity, pricingType, button, originalText) {
    $.ajax({
        url: '{{ route("cart.add") }}',
        method: 'POST',
        data: {
            product_id: {{ $product->id }},
            quantity: quantity,
            pricing_type: pricingType
        },
        // ... rest of ajax call
    });
}
```

## Testing

Created `tests/Feature/ProductPricingTest.php` with tests for:
- Wholesaler pricing visibility
- Retailer pricing limitations
- Edge cases (no pricing data)

## Benefits

1. **Flexible Pricing**: Wholesalers can choose the most cost-effective option
2. **Clear Interface**: Visual indicators show available pricing types
3. **Seamless Integration**: Works with existing cart and checkout flow
4. **Backward Compatibility**: No changes for retailers or existing functionality
5. **Scalable**: Easy to add more pricing types in the future

## Future Enhancements

1. **Bulk Pricing**: Quantity-based pricing tiers
2. **Seasonal Pricing**: Time-based pricing variations
3. **Geographic Pricing**: Location-based pricing
4. **Customer Group Pricing**: Specific pricing for customer segments 