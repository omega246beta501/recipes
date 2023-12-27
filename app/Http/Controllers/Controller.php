<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Bring;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\InternalSetting;
use App\Models\Recipe;
use App\Models\ShoppingList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function randomRecipes() {
        Log::info("recetas");
        $isMenuSet = false;
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = new Collection();
        $ingredients = Ingredient::orderBy('name')->get();

        $recipes = Recipe::includedInMenu();
        $categories = Category::orderBy('name')->get();
        
        if($recipes->count() > 0) {
            $isMenuSet = true;
            $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();
        }
        else {
            $recipes = Recipe::randomRecipes();
        }

        return view('menu', [
            'recipes' => $recipes,
            'isMenuSet' => $isMenuSet,
            'categories' => $categories,
            'shoppingList' => $shoppingListIngredients,
            'ingredients' => $ingredients,
            'allRecipes' => Recipe::all()->sortBy('name'),
        ]);
    }

    public function regenerateRecipes(Request $request) {
        $data = RequestHelper::requestToArray($request);

        $keepedRecipesIds = $data['keepedRecipesIds'];
        $includedCategoriesIds = $data['includedCategoriesIds'];
        $excludedCategoriesIds = $data['excludedCategoriesIds'];
        $includedIngredientsIds = $data['includedIngredientsIds'];
        $searchedRecipes = $data['searchedRecipes'] ?? null;
        $numRecipes = $data['num_recipes'] ?? 6;

        if(count($keepedRecipesIds) > $numRecipes) {
            $numRecipes = count($keepedRecipesIds);
        }

        Log::info($keepedRecipesIds);
        $recipes = Recipe::randomRecipes($keepedRecipesIds, $includedCategoriesIds, $excludedCategoriesIds, $includedIngredientsIds, $numRecipes, $searchedRecipes);

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => false,
            'keepedRecipesIds' => $keepedRecipesIds,
            'ingredients' => Ingredient::orderBy('name')->get()
        ]);
    }

    public function includeRecipesInMenu(Request $request) {
        $data = RequestHelper::requestToArray($request);
        $recipesToInclude = $data['recipesToInclude'];
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = new Collection();

        
        foreach ($recipesToInclude as $recipeId) {
            $recipe = Recipe::find($recipeId);
            $recipe->includeInMenu();
        }

        $recipes = Recipe::randomRecipes($recipesToInclude, [], [], [], count($recipesToInclude));

        $shoppingList->createShoppingList();
        $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();
        
        if(InternalSetting::getValue(InternalSetting::$IS_BRING_ACTIVE) === 'true') {
            $bring = Bring::getToken();
            foreach ($shoppingListIngredients as $ingredient) {
                $bring->addIngredient($ingredient);
            }
        }

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => true,
            'keepedRecipesIds' => $recipesToInclude,
            'shoppingList' => $shoppingListIngredients
        ]);
    }

    public function discardMenu() {
        Recipe::discardMenu();
    }

    public function clearMenu() {
        Recipe::clearMenu();
    }

    public function prueba() {
        return Inertia::render('HelloWorld', [
            'message' => 'Welcome to the Hello World page!'
        ]);
    }
}
