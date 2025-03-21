<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'status',
        'total_cost',
        'order_template_id',
        'material_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'customer_id','id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(OrderTemplate::class,'order_template_id','id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(MaterialOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function process() :HasMany
    {
        return $this->hasMany(OrderProcess::class,'order_id','id');
    }

    // protected static function booted()
    // {
    //     static::retrieved(function ($order) {
    //         $total_cost = 0;
    //         foreach ($order->materials as $material) {
    //             $total_cost += $material->price * $material->count;
    //         }
    //         foreach ($order->process as $process) {
    //             $total_cost += $process->rate_per;
    //         }
    //         $order->total_cost = $total_cost;
    //         $order->save();
    //     });
    // }

    // public function getTotalCostAttribute()
    // {
    //     return 200;
    // }


    public function getTotalCost()
    {
        $total_cost = 0;
        foreach ($this->materials as $material) {
            $total_cost += $material->material->unit_cost * $material->quantity;
        }
        foreach ($this->process as $process) {
            $total_cost += $process->rate_per;
        }
        //parent::update($attributes, $options);
        $this->total_cost = $total_cost;
       // dd($this);

        $this->save();
        return $this->total_cost;
        //dd($this->process());
    }

    // public function update(array $attributes = [], array $options = [])
    // {
    //     $total_cost = 0;
    //     foreach ($this->materials as $material) {
    //         $total_cost += $material->price * $material->count;
    //     }
    //     foreach ($this->process as $process) {
    //         $total_cost += $process->rate_per;
    //     }
    //     parent::update($attributes, $options);
    //     $this->total_cost = $total_cost;
    //     dd($this);

    //     $this->save();
    //     return $this->total_cost;
    // }
}
