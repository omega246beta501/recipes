<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internal_settings')->insertOrIgnore(['key' => 'is_bring_active', 'value' => false]);
        DB::table('bring')->insertOrIgnore(['id' => 1, 'uuid' => null, 'public_uuid' => null, 'token' => null]);
        DB::table('shopping_lists')->insertOrIgnore(['id' => 1, 'name' => 'Compra']);
    }
}
