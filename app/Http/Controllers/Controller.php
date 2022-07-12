<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Bring;
use App\Models\Category;
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

        $includedInMenu = \App\Models\Recipe::includedInMenu()->pluck('id')->toArray();
        $recipes = \App\Models\Recipe::randomRecipes($includedInMenu, [], [], 6);
        $categories = Category::orderBy('name')->get();

        if(count($includedInMenu) > 0) {
            $isMenuSet = true;
            $shoppingListIngredients = $shoppingList->ingredients;
        }

        return view('menu', [
            'recipes' => $recipes,
            'isMenuSet' => $isMenuSet,
            'categories' => $categories,
            'shoppingList' => $shoppingListIngredients
        ]);
    }

    public function regenerateRecipes(Request $request) {
        $data = RequestHelper::requestToArray($request);

        $keepedRecipesIds = $data['keepedRecipesIds'];
        $includedCategoriesIds = $data['includedCategoriesIds'];
        $excludedCategoriesIds = $data['excludedCategoriesIds'];

        Log::info($keepedRecipesIds);
        $recipes = \App\Models\Recipe::randomRecipes($keepedRecipesIds, $includedCategoriesIds, $excludedCategoriesIds, 6);

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => false,
            'keepedRecipesIds' => $keepedRecipesIds
        ]);
    }

    public function includeRecipesInMenu(Request $request) {
        $data = RequestHelper::requestToArray($request);
        $recipesToInclude = $data['recipesToInclude'];
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = new Collection();

        $recipes = \App\Models\Recipe::randomRecipes($recipesToInclude, [], [], 6);

        foreach ($recipesToInclude as $recipeId) {
            $recipe = \App\Models\Recipe::find($recipeId);
            $recipe->includeInMenu();
        }

        Recipe::createShoppingList();
        $shoppingListIngredients = $shoppingList->ingredients;
        
        $bring = Bring::getToken();
        
        foreach ($shoppingListIngredients as $ingredient) {
            $bring->addIngredient($ingredient);
        }

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => true,
            'keepedRecipesIds' => $recipesToInclude,
            'shoppingList' => $shoppingListIngredients
        ]);
    }

    public function discardMenu() {
        \App\Models\Recipe::discardMenu();
    }

    public function clearMenu() {
        Recipe::clearMenu();
    }
}
