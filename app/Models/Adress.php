<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory;

    protected $fillable = [
        'oredr_id',
        'first_name',
        'last_name',
        'phone',
        'street_adress',
        'city',
        'state',
        'zip_code'
        
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }
}

