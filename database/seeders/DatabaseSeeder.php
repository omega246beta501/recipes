<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RecipesSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\IngredientsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CategoriesSeeder::run();
        RecipesSeeder::run();
        IngredientsSeeder::run();
    }
}
