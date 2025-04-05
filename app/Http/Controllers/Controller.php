<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Bring;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\InternalSetting;
use App\Models\Menu;
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

        $menu = Menu::find(1);
        $categories = Category::orderBy('name')->get();
        
        if($menu->is_menu_locked) {
            $isMenuSet = true;
            $recipes = Recipe::includedInMenu();
            $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();
        }
        else {
            $recipes = Recipe::randomRecipes();
        }

        $keepedRecipesIds = $menu->recipes->pluck('id');

        return view('menu', [
            'recipes' => $recipes,
            'isMenuSet' => $isMenuSet,
            'categories' => $categories,
            'shoppingList' => $shoppingListIngredients,
            'ingredients' => $ingredients,
            'allRecipes' => Recipe::all()->sortBy('name'),
            'keepedRecipesIds' => $keepedRecipesIds,
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

        $menu = Menu::find(1);

        $menu->syncMenuRecipes($keepedRecipesIds);
        $keepedRecipesIds = $menu->recipes->pluck('id');

        if(count($keepedRecipesIds) > $numRecipes) {
            $numRecipes = count($keepedRecipesIds);
        }

        Log::info($keepedRecipesIds);
        $recipes = Recipe::randomRecipes($includedCategoriesIds, $excludedCategoriesIds, $includedIngredientsIds, $numRecipes, $searchedRecipes);

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => false,
            'keepedRecipesIds' => $keepedRecipesIds,
            'ingredients' => Ingredient::orderBy('name')->get()
        ]);
    }

    public function closeMenu(Request $request) {
        $data = RequestHelper::requestToArray($request);
        $recipesToInclude = $data['recipesToInclude'];
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = new Collection();

        $menu = Menu::find(1);

        $menu->syncMenuRecipes($recipesToInclude);
        $menu->is_menu_locked = true;
        $menu->save();

        Recipe::logUsedRecipes($menu->recipes);

        $keepedRecipesIds = $menu->recipes->pluck('id');

        $recipes = Recipe::randomRecipes([], [], [], count($recipesToInclude));

        $shoppingList->createShoppingList();
        $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();
        
        if(InternalSetting::getValue(InternalSetting::$IS_BRING_ACTIVE) === 'true') {
            $bring = Bring::getToken();
            foreach ($shoppingListIngredients as $ingredient) {
                $bring->addIngredient($ingredient);
            }

            $bring->addDefaultIngredients();
        }

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => true,
            'keepedRecipesIds' => $keepedRecipesIds,
            'shoppingList' => $shoppingListIngredients
        ]);
    }

    public function discardMenu() {
        $menu = Menu::find(1);
        $menu->discardMenu();
    }

    public function clearMenu() {
        $menu = Menu::find(1);
        $menu->clearMenu();
    }
}
