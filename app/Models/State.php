<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'state_code', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
