<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
       // 'product_type_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   /* public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }*/
}
