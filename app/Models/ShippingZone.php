<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function countries()
    {
        return $this->belongsToMany(\App\Models\Country::class, 'country_shipping_zone');
    }

    public function shippingMethods()
    {
        return $this->hasMany(\App\Models\ShippingMethod::class);
    }
}
