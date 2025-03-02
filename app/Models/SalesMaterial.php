<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesMaterial extends Model
{
    protected $fillable = [
        'sales_id',
        'material_id',
        'count',
        'warehouse_id',
        'order_id',
        'price',
        'total',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class,'sales_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id'); // Замість 'sales_id' використовуйте правильну назву колонки
    }

}
