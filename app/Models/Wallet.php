<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{


    protected $fillable = [
        'name',
        'description',
        'amount',
    ];


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
