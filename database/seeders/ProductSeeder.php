<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(500)
            ->create()->each(function ($product) {
                $attributeValues = AttributeValue::query()->select('id', 'attribute_id')->inRandomOrder()->limit(rand(2, 7))->pluck('id')->toArray();
                $product->attributeValues()->attach($attributeValues);
            });
    }
}
