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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function randomRecipes() {
        Log::info("recetas");
        $isMenuSet = false;
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = new Collection();
        $ingredients = Ingredient::orderBy('name')->get();

        $includedInMenu = Recipe::includedInMenu()->pluck('id')->toArray();
        $recipes = Recipe::randomRecipes($includedInMenu, [], [], [], 6);
        $categories = Category::orderBy('name')->get();

        if(count($includedInMenu) > 0) {
            $isMenuSet = true;
            $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();
        }

        return view('menu', [
            'recipes' => $recipes,
            'isMenuSet' => $isMenuSet,
            'categories' => $categories,
            'shoppingList' => $shoppingListIngredients,
            'ingredients' => $ingredients,
            'allRecipes' => Recipe::all(),
        ]);
    }

    public function regenerateRecipes(Request $request) {
        $data = RequestHelper::requestToArray($request);

        $keepedRecipesIds = $data['keepedRecipesIds'];
        $includedCategoriesIds = $data['includedCategoriesIds'];
        $excludedCategoriesIds = $data['excludedCategoriesIds'];
        $includedIngredientsIds = $data['includedIngredientsIds'];
        $searchedRecipes = $data['searchedRecipes'] ?? null;

        Log::info($keepedRecipesIds);
        $recipes = Recipe::randomRecipes($keepedRecipesIds, $includedCategoriesIds, $excludedCategoriesIds, $includedIngredientsIds, 6, $searchedRecipes);

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

        $recipes = Recipe::randomRecipes($recipesToInclude, [], [], [], 6);

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
}
