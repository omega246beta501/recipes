<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //Insert settings row with default values
        DB::table('menus')->insertOrIgnore(['id' => 1, 'name' => 'Default']);
    }
}
