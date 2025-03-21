<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProcess extends Model
{
    protected $fillable = [
        'step',
        'user_to',
        'status',
        'start_time',
        'order_id',
        'end_time',
        'rate_per',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_to');
    }

}
