<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'iso3', 'iso2', 'region'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'country_region');
    }
}
