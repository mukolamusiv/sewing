<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
