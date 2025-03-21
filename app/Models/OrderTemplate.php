<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTemplate extends Model
{
    use  SoftDeletes;

    protected $fillable = [
        'name',
        'material_id',
        'price',
    ];

    public function material() :BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function materials() :BelongsToMany
    {
        return $this->belongsToMany(Material_orders_tempale::class, 'material_order_to_templates', 'order_template_id','material_orders_tempales_id');
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(OrderProcessTemplate::class, 'order_process_to_templates', 'order_template_id', 'order_process_template_id');
    }
}
