<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $guarded = ['id'];
    public function eventPrice()
    {
        return $this->belongsTo(event_prices::class, 'id_event_price', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(payments::class, 'id_payment', 'id');
    }
}