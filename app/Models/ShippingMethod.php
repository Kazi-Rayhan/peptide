<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'shipping_zone_id',
        'name',
        'type',
        'rate',
    ];

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }
}
