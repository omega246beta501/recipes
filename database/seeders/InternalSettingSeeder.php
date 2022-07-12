<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //Insert settings row with default values
        DB::insertOrIgnore('insert into internal_settings (internal_settings.`key`, internal_settings.value) values ("is_bring_active", "true")');
    }
}
