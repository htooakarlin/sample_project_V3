<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function purchase() {
        return $this->hasOne(Purchase::class);
    }
}
