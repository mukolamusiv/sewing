<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function material() :HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(OrderProcessTemplate::class, 'order_process_to_templates', 'order_template_id', 'order_process_template_id');
    }
}
