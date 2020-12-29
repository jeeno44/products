<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirtsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name_categories' => "Первая категория"],
            ['name_categories' => "Вторая категория"],
            ['name_categories' => "Третья категория"],
            ['name_categories' => "Четвёртая категория"],
            ['name_categories' => "Пятая категория"],
                ]
        );

        DB::table('products')->insert([
            [
                'name_product'  => "Первый продукт",
                'price'         => 100,
            ],
            [
                'name_product' => "Второй продукт",
                'price'         => 200,
            ],
            [
                'name_product' => "Третий продукт",
                'price'         => 600,
            ],
            [
                'name_product' => "Четвёртый продукт",
                'price'         => 300,
            ],
            [
                'name_product' => "Пятый продукт",
                'price'         => 400,
            ],
                ]
        );


        DB::table('cat_prods')->insert([
            [
                "categories_id" => 2,
                "product_id" => 1,
            ],
            [
                "categories_id" => 1,
                "product_id" => 1,
            ],
            [
                "categories_id" => 5,
                "product_id" => 1,
            ],
            [
                "categories_id" => 5,
                "product_id" => 2,
            ],
            [
                "categories_id" => 1,
                "product_id" => 2,
            ],
            ]
        );
    }
}
