<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 
        'price', 
        'units',  
        'description', 
        'image'
    ];
    /**
     * 1 Product can have many Orders
    */
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
