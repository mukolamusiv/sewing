<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProcessTemplate extends Model
{
    //
    protected $fillable = [
        'step',
        'hours_worked',
        'rate_per_hour',
        'is_moving',
    ];


    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(OrderProcessTemplate::class,'order_process_to_templates','order_process_templates_id','order_templates_id');
    }
}
