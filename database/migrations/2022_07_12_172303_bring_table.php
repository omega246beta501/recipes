<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('bring', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->uuid('public_uuid')->nullable();
            $table->text('token')->nullable();
            $table->timestamps();
        });

        //Insert bring row with default values
        DB::insert('insert into bring (uuid, public_uuid, token) values (?, ?, ?)', [null, null, null]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop table
        Schema::dropIfExists('bring');
    }
};
