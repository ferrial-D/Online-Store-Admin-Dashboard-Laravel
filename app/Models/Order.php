<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grand_total',
        'payement_method',
        'payement_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    public function adress(){
        return $this->hasMany(Adress::class);

    }

}
