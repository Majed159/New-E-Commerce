<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['parent_id' =>null ,'name'=>'Clothing','url'=>'clothing'],
            ['parent_id' =>null ,'name'=>'Electronics','url'=>'electronics'],
            ['parent_id' =>null ,'name'=>'appliances','url'=>'appliances'],
            ['parent_id' =>1 ,'name'=>'Men','url'=>'men'],
            ['parent_id' =>1 ,'name'=>'Women','url'=>'women'],
            ['parent_id' =>1 ,'name'=>'Kids','url'=>'kids'],
        ];
        foreach($categories as $category){
            Category::create([
                'parentId'=> $category['parent_id'],
                'name' => $category['name'],
                'url' => $category['url'],
                'image' =>'',
                'size_chart' =>'',
                'discount' =>0,
                'description'=>'',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'menu_status'=>1,
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ]);
        }
    }
}
