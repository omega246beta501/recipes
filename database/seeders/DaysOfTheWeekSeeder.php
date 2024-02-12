<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysOfTheWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //Insert settings row with default values
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 1, 'name' => 'Lunes']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 2, 'name' => 'Martes']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 3, 'name' => 'Miércoles']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 4, 'name' => 'Jueves']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 5, 'name' => 'Viernes']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 6, 'name' => 'Sábado']);
        DB::table('days_of_the_week')->insertOrIgnore(['id' => 7, 'name' => 'Domingo']);
    }
}
