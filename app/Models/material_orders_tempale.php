<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material_orders_tempale extends Model
{
    //

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($orderMaterial) {
    //         // Отримуємо склад, матеріал і кількість
    //         $warehouseId = $orderMaterial->warehouse_id;
    //         $materialId = $orderMaterial->material_id;
    //         $quantity = $orderMaterial->quantity;

    //         // Зменшуємо кількість товару на складі
    //         \App\Models\Inventory::where('warehouse_id', $warehouseId)
    //             ->where('material_id', $materialId)
    //             ->decrement('quantity', $quantity);
    //     });

    //     dd('test');
    // }


}
