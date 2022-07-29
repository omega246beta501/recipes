<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //Insert settings row with default values
        DB::table('internal_settings')->insertOrIgnore(['key' => 'is_bring_active']);
        DB::table('user_settings')->insertOrIgnore(['setting_id' => 1, 'user_id' => 1, 'value' => 'true']);
    }
}
