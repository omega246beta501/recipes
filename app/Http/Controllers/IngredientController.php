<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;
use Illuminate\Support\Str;

class IngredientController extends Controller
{

    public function attachRecipe(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $recipeId       = $data['recipeId'];
        $name           = $data['newIngredientName'] ?? null;
        $qty            = $data['newIngredientQty'] ?? null;
        $description    = $data['newIngredientDescription'] ?? null;

        $recipe     = Recipe::findOrFail($recipeId);
        $ingredient = Ingredient::createOrGetIngredient($name);

        $recipe->ingredients()->detach($ingredient);
        $recipe->ingredients()->attach($ingredient, ["qty" => $qty, "description" => $description]);

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
        $qty            = $data['qty'] ?? null;
        $description    = $data['description'] ?? null;

        $recipe     = Recipe::findOrFail($recipeId);
        $ingredient = Ingredient::findOrFail($ingredientId);

        $recipe->ingredients()->updateExistingPivot($ingredient, ["qty" => $qty, "description" => $description]);

        $attachedIngredients = $recipe->ingredients()->orderBy('name')->get();

        return view('components.ingredients.grid', [
            "recipe" => $recipe,
            "attachedIngredients" => $attachedIngredients
        ]);
    }

    public function queryIngredients(Request $request)
    {
        $data = RequestHelper::requestToArray($request);
        $term = Str::title($data['term']);
        if(!empty($term)) {
            $gridId = $data['gridId'];
            $recipeId = $data['recipeId'];
            $recipe = Recipe::find($recipeId);
            $recipeIngredients = $recipe->ingredients()->pluck('id');
            $ingredients = Ingredient::where('name', 'like', '%' . $term . '%')
                                        ->orderBy('name')->get();
            
            if(!$ingredients->contains(function($value) use ($term) {
                return $value->name == $term;
            })) {
                $typedIngredient = new stdClass();
                $typedIngredient->name = $term;
                $ingredients->prepend($typedIngredient);
        
                return view('components.elements.grid', [
                    'ingredients' => $ingredients,
                    'gridId' => $gridId,
                    'recipe' => $recipe,
                    'cellOnClickCallback' => ''
                ]);
            }
        }
    }
}
