<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    // protected $guarded = [];
    protected $table= 'producttable.products';
    protected $fillable = [
        'name', 'price', 'stock'
    ];
}
