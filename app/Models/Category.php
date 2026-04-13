<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    public function parentcategory(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parentId')
            ->select('id', 'name', 'url')
            ->where('status', 1)
            ->orderBy('id', 'ASC');
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parentId')->where(['status' => 1]);
    }

    public static function getCategories($type)
    {
        $getCategories = Category::with(['parentcategory', 'subcategories'])
            ->where('parentId', NuLL)
            ->where('status', 1);
            if($type =="Front"){
                $getCategories = $getCategories->where('menu_status', 1);
            }
            return $getCategories->get()->toArray();
    }
}
