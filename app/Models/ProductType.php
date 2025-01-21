<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use softDeletes;
    protected $fillable = [
        'name',
        'description',
        'unit',
    ];
}
