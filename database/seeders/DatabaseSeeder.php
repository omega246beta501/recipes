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
        DB::insertOrIgnore('insert into bring (id, uuid, public_uuid, token) values (?, ?, ?)', [1, null, null, null]);
        DB::insertOrIgnore('insert into shopping_lists (id, name) values (?, ?)', [1, 'Compra']);
    }
}
