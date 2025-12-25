<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class event_prices extends Model
{

    protected $guarded = ['id'];
    public function event()
    {
        return $this->belongsTo(events::class);
    }
}
