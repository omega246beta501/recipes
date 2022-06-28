<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        Ingredient::factory()
                    ->has(Recipe::factory()->count(2))
                    ->count(5)
                    ->create();
    }
}
