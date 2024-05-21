<?php

namespace Database\Seeders;

use App\Repositories\Products\Enum\ProductType;
use App\Repositories\Products\Models\Product;
use App\Repositories\Products\Models\ProductPrice;
use Illuminate\Database\Seeder;

class FrozenWorkbookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $productData = [
            'type' => ProductType::WORKBOOK,
            'slug' => 'frozen',
            'name' => 'Холодное сердце',
        ];

        $product = Product::create($productData);

        $pricesData = [
            [
                'key' => 'digital',
                'price' => 9,
            ],
            [
                'key' => 'printed',
                'price' => 69,
            ]
        ];

        foreach ($pricesData as $price) {
            $price['product_id'] = $product->id;
            ProductPrice::create($price);
        }
    }
}
