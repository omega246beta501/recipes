<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RecipesSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\IngredientsSeeder;
use Illuminate\Support\Facades\DB;

class DevSeeder extends Seeder
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
        SettingSeeder::run();
        //Insert bring row with default values
        DB::insert('insert into bring (uuid, public_uuid, token) values (?, ?, ?)', [null, null, null]);
        DB::insert('insert into shopping_lists (id, name) values (?, ?)', [1, 'Compra']);
    }
}
