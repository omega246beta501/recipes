<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Recipe;
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
        $includedInMenu = \App\Models\Recipe::includedInMenu()->pluck('id')->toArray();
        $recipes = \App\Models\Recipe::randomRecipes($includedInMenu, [], [], 6);
        $categories = Category::orderBy('name')->get();

        if(count($includedInMenu) > 0) {
            $isMenuSet = true;
        }

        return view('menu', [
            'recipes' => $recipes,
            'isMenuSet' => $isMenuSet,
            'categories' => $categories
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

        $recipes = \App\Models\Recipe::randomRecipes($recipesToInclude, [], [], 6);

        foreach ($recipesToInclude as $recipeId) {
            $recipe = \App\Models\Recipe::find($recipeId);
            $recipe->includeInMenu();
        }

        return view('components.menu.table', [
            'recipes' => $recipes,
            'isMenuSet' => true,
            'keepedRecipesIds' => $recipesToInclude
        ]);
    }

    public function discardMenu() {
        \App\Models\Recipe::discardMenu();
    }

    public function clearMenu() {
        Recipe::clearMenu();
    }
}
