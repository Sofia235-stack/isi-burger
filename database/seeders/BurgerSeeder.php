<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BurgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('burgers')->insert([
            [
                'nom' => 'Classic Burger',
                'prix' => 10000,
                'image' => 'images/classic_burger.jpg',
                'description' => 'A classic burger with lettuce, tomato, and cheese.',
                'stock' => 50,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Cheese Burger',
                'prix' => 15000,
                'image' => 'images/cheese_burger.jpg',
                'description' => 'A delicious cheese burger with extra cheese.',
                'stock' => 40,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Bacon Burger',
                'prix' => 20000,
                'image' => 'images/bacon_burger.jpg',
                'description' => 'A tasty burger with crispy bacon.',
                'stock' => 30,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Veggie Burger',
                'prix' => 12000,
                'image' => 'images/veggie_burger.jpg',
                'description' => 'A healthy burger with fresh vegetables.',
                'stock' => 20,
                'archive' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Fish Burger',
                'prix' => 18000,
                'image' => 'images/fish_burger.jpg',
                'description' => 'A delicious burger with fish fillet.',
                'stock' => 10,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chicken Burger',
                'prix' => 16000,
                'image' => 'images/chicken_burger.jpg',
                'description' => 'A tasty burger with crispy chicken fillet.',
                'stock' => 5,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Double Burger',
                'prix' => 25000,
                'image' => 'images/double_burger.jpg',
                'description' => 'A double burger with extra patties.',
                'stock' => 3,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Spicy Burger',
                'prix' => 17000,
                'image' => 'images/spicy_burger.jpg',
                'description' => 'A spicy burger with jalapenos and hot sauce.',
                'stock' => 2,
                'archive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}