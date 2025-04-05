<?php

namespace App\Http\Controllers;

use App\Api\MercadonaAPI;
use App\Helpers\RequestHelper;
use App\Http\Resources\IngredientsWithMercadona;
use App\Models\Ingredient;
use App\Models\MercadonaProduct;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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
        $term = $data['term'];
        $ingredients = Ingredient::where('name', 'like', '%' . $term . '%')->orderBy('name')->pluck('name');

        return $ingredients;
    }

    public function index()
    {
        $allIngredients = Ingredient::with('mercadonaProduct')->orderBy('name')->get();

        return Inertia::render('IngredientLinkerPage', [
            'list' => $allIngredients
        ]);
    }

    public function queryMercadonaProduct(Request $request)
    {
        $query = $request->input('query');
        $mercadonaAPI = new MercadonaAPI();
        return [
            "mercadonaIngredients" => $mercadonaAPI->queryProducts($query),
        ];
    }

    public function attachMercadonaProduct(Request $request)
    {
        // Validate incoming data.
        $data = $request->all();
    
        // Retrieve the ingredient.
        $ingredient = Ingredient::findOrFail($data['ingredient_id']);
    
        // Check if a MercadonaProduct id was provided.
        $mercadonaProductModel = MercadonaProduct::where('product_id', $data['mercadonaProduct']['product_id'])->first();
        
        if(!$mercadonaProductModel) {
            $mercadonaProductModel = MercadonaProduct::create([
                'product_id' => $data['mercadonaProduct']['product_id'],
                'name'       => $data['mercadonaProduct']['name'],
                'url'        => $data['mercadonaProduct']['url'],
                'image_path' => $data['mercadonaProduct']['image_path'],
            ]);
        }
    
        // Attach the MercadonaProduct to the ingredient.
        $ingredient->mercadona_product_id = $mercadonaProductModel->id;
        $ingredient->save();
    
        // Return a JSON response.
        return response()->json([
            'message' => 'Mercadona product attached successfully.',
            // 'ingredient' => $ingredient,
            'mercadonaProduct' => $mercadonaProductModel,
        ], 200);
    }
    
}
