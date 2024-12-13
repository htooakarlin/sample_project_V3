<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'car_id',
        'purchase_date',
    ];

    public function car() { 
        return $this->belongsTo(Car::class); 
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
