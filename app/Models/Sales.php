<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{

    protected $fillable = [
        'companies_id',
        'user_id',
       // 'order_id',
        'total',
        'discount',
        'total_discount',
        'total_payment',
    ];

    public function update(array $attributes = [], array $options = [])
    {
        $this->total();
        //$this->total_discount = $this->total_discount();
        //$this->total_payment = $this->total_discount - $this->total_discount * $this->discount / 100;
        return parent::update($attributes, $options);
    }


    public function materials()
    {
        return $this->hasMany(SalesMaterial::class);
    }
/*
public function order(): BelongsTo
{
    return $this->belongsTo(Order::class, 'order_id'); // Замість 'sales_id' використовуйте правильну назву колонки
}*/

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function total()
    {
        $this->total = $this->materials->sum('total');
        $this->total_discount = $this->total - ($this->total * $this->discount / 100);
        $this->save();
        //dd($this->total);
       // return $this->total;
        //return $this->materials->sum('total');
    }
}
