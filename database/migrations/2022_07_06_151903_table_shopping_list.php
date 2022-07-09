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
        Schema::create('shopping_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ingredient_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('list_id')->nullable();
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->text('description')->nullable();
            $table->foreign('list_id')->references('id')->on('shopping_lists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::insert('insert into shopping_lists (id, name) values (?, ?)', [1, 'Compra']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_lists');
        Schema::dropIfExists('shopping_lists');
    }
};
