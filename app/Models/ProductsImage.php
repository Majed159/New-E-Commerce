<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
    protected $fillable = ['product_id', 'image', 'sort_order', 'status'];
    protected $table = 'products_images';
}
