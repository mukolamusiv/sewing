<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{

    use softDeletes;
    protected $fillable = [
        'warehouse_id',
        'material_id',
        'quantity',
        'unit',
        'balance_before',
        'balance_after',
        'supplier_id',
        'movement_type', // 'in' or 'out'
        'user_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
