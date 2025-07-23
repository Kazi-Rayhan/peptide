<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxClass extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rate',
    ];

    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
}
}
