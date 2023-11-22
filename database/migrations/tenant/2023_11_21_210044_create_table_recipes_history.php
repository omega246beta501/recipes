<?php

use App\Models\Recipe;
use App\Models\RecipeHistory;
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
        Schema::create('recipes_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->date('used_at');
        });

        Schema::table('recipes_history', function (Blueprint $table) {
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });

        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {
            $last_used_at = $recipe->getAttributes()['last_used_at'];

            if($last_used_at != Recipe::$DEFAULT_DATE) {
                $recipeHistory = new RecipeHistory();
                $recipeHistory->recipe_id = $recipe->id;
                $recipeHistory->used_at = $recipe->getAttributes()['last_used_at'];
                $recipeHistory->save();
            }
        }

        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('last_used_at');
            $table->dropColumn('previous_last_used_at');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->date('last_used_at')->after('kcal')->nullable(false)->default('1979-12-31');;
            $table->date('previous_last_used_at')->after('last_used_at')->nullable(false)->default('1979-12-31');;
        });

        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {

            if($recipe->recipeLogs->count() > 0) {
                $recipe->last_used_at = $recipe->recipeLogs()->latest('used_at')->first()->used_at;
            }
            $recipe->save();
        }

        Schema::dropIfExists('recipes_history');
    }
};
