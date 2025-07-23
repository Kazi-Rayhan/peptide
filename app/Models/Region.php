<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'slug'];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_region');
    }
}
