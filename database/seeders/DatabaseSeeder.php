<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RecipesSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\IngredientsSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        InternalSettingSeeder::run();
        //Insert bring row with default values
        DB::table('bring')->insertOrIgnore(['id' => 1, 'uuid' => null, 'public_uuid' => null, 'token' => null]);
        DB::table('shopping_lists')->insertOrIgnore(['id' => 1, 'name' => 'Compra']);
    }
}
