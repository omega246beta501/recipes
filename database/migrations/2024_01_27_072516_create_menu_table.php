<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('default');
            $table->boolean('is_menu_locked')->default(false)->nullable(false);
            $table->timestamps();
        });

        Schema::create('days_of_the_week', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
        });

        Schema::create('menu_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('day_id')->nullable(true);
            $table->timestamps();
        });

        Schema::table('menu_recipe', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days_of_the_week');
        });

        \Database\Seeders\DaysOfTheWeekSeeder::run();
        \Database\Seeders\MenuSeeder::run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_recipe');
        Schema::dropIfExists('days_of_the_week');
        Schema::dropIfExists('menus');
    }
};
