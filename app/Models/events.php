<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    protected $guarded = ['id'];
    public function prices()
    {
        return $this->hasMany(event_prices::class);
    }
}
