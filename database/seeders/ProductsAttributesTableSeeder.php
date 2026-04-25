<?php

namespace Database\Seeders;

use App\Models\ProductsAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributesRecords = [
            [
                'products_id' => 2,
                'sku' => 'BTS001-S',
                'size' =>'Small',
                'price' => 1500,
                'stock' => 10,
                'sort_order' => 2,
                'status' => 1,
            ],
            [
                'products_id' => 2,
                'sku' => 'BTS001-M',
                'size' =>'Medium',
                'price' => 1600,
                'stock' => 20,
                'sort_order' => 2,
                'status' => 1,
            ],
            [
                'products_id' => 2,
                'sku' => 'BTS001-L',
                'size' =>'Large',
                'price' => 1700,
                'stock' => 10,
                'sort_order' => 3,
                'status' => 1,
            ]
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
