<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bring_user')->nullable()->after('remember_token');
            $table->string('bring_password')->nullable()->after('bring_user');
        });

        Schema::table('bring', function (Blueprint $table) {
            $table->string('list_uuid')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bring_user');
            $table->dropColumn('bring_password');
        });

        Schema::table('bring', function (Blueprint $table) {
            $table->dropColumn('list_uuid');
        });
    }
};
