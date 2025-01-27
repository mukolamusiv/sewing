<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'status',
        'total_cost',
        'order_template_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'customer_id','id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(OrderTemplate::class,'order_template_id','id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(MaterialOrder::class);
    }

    public function process() :HasMany
    {
        return $this->hasMany(OrderProcess::class,'order_id','id');
    }
}
