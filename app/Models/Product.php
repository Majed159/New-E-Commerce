<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'product_video',
    ];

    public function Category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public function product_images(): HasMany
    {
        return $this->hasMany(ProductsImage::class);
    }
}
