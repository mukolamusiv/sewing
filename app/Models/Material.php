<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use softDeletes;
    protected $fillable = [
        'name',
        'barcode',
        'description',
        'unit',
        'photo',
        'category_id',
        'unit_cost',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

   /* public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }*/
}
