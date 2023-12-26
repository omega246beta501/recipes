<?php

use App\Models\Instruction;
use App\Models\Recipe;
use App\Models\RecipePart;
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
        Schema::create('recipe_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('recipe_id');
            $table->timestamps();
        });

        Schema::table('recipe_parts', function (Blueprint $table) {
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });

        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedTinyInteger('order')->default(1);
            $table->unsignedBigInteger('part_id')->nullable(true);
            $table->timestamps();
        });

        Schema::table('instructions', function (Blueprint $table) {
            $table->foreign('part_id')->references('id')->on('recipe_parts')->onDelete('set null');
        });

        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->unsignedBigInteger('part_id')->after('recipe_id')->nullable(true);
            $table->foreign('part_id')->references('id')->on('recipe_parts')->onDelete('set null');
        });

        $allRecipes = Recipe::all();

        foreach ($allRecipes as $recipe) {
            $defaultPart = new RecipePart();
            $defaultPart->name = 'default';
            $defaultPart->recipe_id = $recipe->id;

            $defaultPart->save();

            $description = $recipe->description;
    
            if($description != null || $description != '') {
                $parts = preg_split("/\r\n|\r|\n/", $description);
    
                foreach ($parts as $part) {
                    if(!empty($part)) {
                        if(str_contains($part, "http")) {
                            $url = str_replace("URL: ", "", $part);
                            $recipe->url = $url;
                            $recipe->save();
                        }
                        else {
                            $instruction = new Instruction();
                            $lastInstructionOrder = $defaultPart->instructions()->orderBy('id', 'desc')->first()->order ?? 0;
        
                            $instruction->description = preg_replace('/^(\d+\.|\-|\d+-)\s*/', '', $part);
                            $instruction->part_id = $defaultPart->id;
                            $instruction->order = $lastInstructionOrder + 1;
                            $instruction->save();
                        }
                    }
                }
            }
    
            $ingredients = $recipe->ingredients;
    
            foreach ($ingredients as $ingredient) {
                $ingredient->pivot->part_id = $defaultPart->id;
                $ingredient->pivot->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->dropForeign(['part_id']);
            $table->dropColumn('part_id');
        });

        Schema::dropIfExists('instructions');
        Schema::dropIfExists('recipe_parts');
    }
};
