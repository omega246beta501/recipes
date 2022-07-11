<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    public function attachRecipe(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $recipeId       = $data['recipeId'];
        $name           = $data['newIngredientName'] ?? null;
        $description    = $data['newIngredientDescription'] ?? null;

        $recipe     = Recipe::findOrFail($recipeId);
        $ingredient = Ingredient::createOrGetIngredient($name);

        $recipe->ingredients()->detach($ingredient);
        $recipe->ingredients()->attach($ingredient, ["description" => $description]);

        $attachedIngredients = $recipe->ingredients()->orderBy('name')->get();

        return view('components.ingredients.grid', [
            "recipe" => $recipe,
            "attachedIngredients" => $attachedIngredients
        ]);
    }

    public function detachRecipe(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $recipeId = $data['recipeId'];
        $ingredientId = $data['ingredientId'];

        $recipe = Recipe::findOrFail($recipeId);
        $ingredient = Ingredient::findOrFail($ingredientId);

        $recipe->ingredients()->detach($ingredient);

        return response()->json(['status' => 'ok']);
    }

    public function updateAttachedRecipe(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $recipeId       = $data['recipeId'];
        $ingredientId   = $data['ingredientId'];
        $description    = $data['description'] ?? null;

        $recipe     = Recipe::findOrFail($recipeId);
        $ingredient = Ingredient::findOrFail($ingredientId);

        $recipe->ingredients()->updateExistingPivot($ingredient, ["description" => $description]);

        $attachedIngredients = $recipe->ingredients()->orderBy('name')->get();

        return view('components.ingredients.grid', [
            "recipe" => $recipe,
            "attachedIngredients" => $attachedIngredients
        ]);
    }

    public function queryIngredients(Request $request)
    {
        $data = RequestHelper::requestToArray($request);
        $term = $data['term'];
        $ingredients = Ingredient::where('name', 'like', '%' . $term . '%')->orderBy('name')->pluck('name');

        return $ingredients;
    }
}
