<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialOrder extends Model
{

    protected $fillable = [
        'quantity',
        'order_id',
        'material_id',
        'warehouse_id',
        'write_off'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::updated(function($orderMaterial){

            if(!is_null($orderMaterial->write_off)){
                // Отримуємо склад, матеріал і кількість
            $warehouseId = $orderMaterial->warehouse_id;
            $materialId = $orderMaterial->material_id;
            $quantity = $orderMaterial->quantity;

            // Зменшуємо кількість товару на складі
            \App\Models\Inventory::where('warehouse_id', $warehouseId)
                ->where('material_id', $materialId)
                ->decrement('quantity', $quantity);

            \App\Models\StockMovement::create([
                'warehouse_out_id' => $orderMaterial->warehouse_id, // Звідки взяли матеріал
                'material_id' => $orderMaterial->material_id,
                'quantity' => $orderMaterial->quantity,
                'supplier_id' => null, // Якщо потрібно
                'movement_type' => 'out', // Витрата матеріалу
                'user_id' => auth()->id(), // Хто зробив переміщення
            ]);
            }
           // dd($data,$orderMaterial);
        });

        // static::created(function ($orderMaterial) {
        //     // Отримуємо склад, матеріал і кількість
        //     $warehouseId = $orderMaterial->warehouse_id;
        //     $materialId = $orderMaterial->material_id;
        //     $quantity = $orderMaterial->quantity;

        //     // Зменшуємо кількість товару на складі
        //     \App\Models\Inventory::where('warehouse_id', $warehouseId)
        //         ->where('material_id', $materialId)
        //         ->decrement('quantity', $quantity);

        //     \App\Models\StockMovement::create([
        //         'warehouse_out_id' => $orderMaterial->warehouse_id, // Звідки взяли матеріал
        //         'material_id' => $orderMaterial->material_id,
        //         'quantity' => $orderMaterial->quantity,
        //         'supplier_id' => null, // Якщо потрібно
        //         'movement_type' => 'out', // Витрата матеріалу
        //         'user_id' => auth()->id(), // Хто зробив переміщення
        //     ]);
        //       //  dd($warehouseId, $materialId, $quantity);
        // });



        static::deleted(function ($orderMaterial) {
            \App\Models\StockMovement::create([
                'warehouse_in_id' => $orderMaterial->warehouse_id, // Куди повернули
                'material_id' => $orderMaterial->material_id,
                'quantity' => $orderMaterial->quantity,
                'supplier_id' => null,
                'movement_type' => 'in', // Повернення на склад
                'user_id' => auth()->id(),
            ]);
        });



       // dd('test');
    }


    public function write_off_create(){
        $warehouseId = $this->warehouse_id;
        $materialId = $this->material_id;
        $quantity = $this->quantity;

        // Зменшуємо кількість товару на складі
        \App\Models\Inventory::where('warehouse_id', $warehouseId)
            ->where('material_id', $materialId)
            ->decrement('quantity', $quantity);

        \App\Models\StockMovement::create([
            'warehouse_out_id' => $this->warehouse_id, // Звідки взяли матеріал
            'material_id' => $this->material_id,
            'quantity' => $this->quantity,
            'supplier_id' => null, // Якщо потрібно
            'movement_type' => 'out', // Витрата матеріалу
            'user_id' => auth()->id(), // Хто зробив переміщення
        ]);
    }

}
