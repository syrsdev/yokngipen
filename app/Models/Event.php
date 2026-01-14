<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function prices()
    {
        return $this->hasMany(event_prices::class, 'events_id', 'id');
    }
}
