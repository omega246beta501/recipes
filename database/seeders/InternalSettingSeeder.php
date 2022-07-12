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
        DB::table('internal_settings')->insertOrIgnore(['key' => 'is_bring_active', 'value' => 'true']);
    }
}
