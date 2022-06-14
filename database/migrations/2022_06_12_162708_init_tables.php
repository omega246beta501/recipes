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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->timestamps();
        });


        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->string('description')->nullable();
            $table->unsignedInteger('kcal')->nullable();
            $table->date('last_used_at')->nullable(false)->default('1979-12-31');
            $table->timestamps();
        });

        Schema::create('category_recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->unsignedBigInteger('recipe_id')->nullable(false);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_recipes');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('recipes');
    }
};
