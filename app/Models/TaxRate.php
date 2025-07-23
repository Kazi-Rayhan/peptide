<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = [
        'tax_class_id',
        'country_id',
        'state_id',
        'rate',
    ];

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
