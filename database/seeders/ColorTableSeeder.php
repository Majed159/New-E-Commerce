<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Black', 'White', 'Red', 'Green', 'Blue', 'Yellow', 'Orange','Pink','Olive','Brown','Gray','Purple', 'Multi'];
        foreach ($colors as $colorName) {
            $color = new Color;
            $color->name = $colorName;
            $color->status = 1;
            $color->save();
        }
    }
}
