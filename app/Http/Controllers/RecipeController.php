<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Recipe;
use App\View\Components\Forms\Recipe as FormsRecipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('recipes', [
            'tableTitle' => 'Todas las recetas',
            'recipes' => $recipes,
            'categories' => $categories
        ]);

    }

    public function test() {
        $recipes = Recipe::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('prueba', [
            'tableTitle' => 'Todas las recetas',
            'recipes' => $recipes,
            'categories' => $categories
        ]);

    }

    public function store(Request $request) {
        $data = RequestHelper::requestToArray($request);
        
        $newUrl         = $data['newUrl'] ?? null;
        $newName        = $data['newName'];
        $newKcal        = $data['newKcal'] ?? null;
        $newPrice       = $data['newPrice'] ?? null;
        $newServings    = $data['newServings'] ?? null;
        $newDescription = $data['newDescription'] ?? null;

        $categoriesToAttach = $data['categoriesToAttach'];
        $categoriesModels = new Collection();

        try {
            DB::beginTransaction();

            if(!empty($categoriesToAttach)) {
                $categoriesModels = Recipe::whereIn('id', $categoriesToAttach)->get();
            }
    
            $newRecipe = new Recipe();
            $newRecipe->name            = $newName;
            $newRecipe->kcal            = $newKcal;
            $newRecipe->price           = $newPrice;
            $newRecipe->description     = $newDescription;
            $newRecipe->url             = $newUrl;

            if($newServings) {
                $newRecipe->servings        = $newServings;
            }
            
            $newRecipe->save();
    
            $newRecipe->categories()->attach($categoriesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function updateView($id) {

        $recipe = Recipe::findOrFail($id);
        $attachedCategories = $recipe->categories;
        $allcategories = Category::orderBy('name')->get();
        $attachedIngredients = $recipe->ingredients()->orderBy('name')->get();

        return view('components.forms.recipe', [
            'recipe' => $recipe,
            'categories' => $allcategories,
            'attachedCategories' => $attachedCategories,
            'attachedIngredients' => $attachedIngredients,
        ]);
    }

    public function update(Request $request) {

        $data = RequestHelper::requestToArray($request);
        
        $id             = $data['id'];
        $newUrl         = $data['newUrl'] ?? null;
        $newName        = $data['newName'] ?? null;
        $newKcal        = $data['newKcal'] ?? null;
        $newPrice       = $data['newPrice'] ?? null;
        $newServings    = $data['newServings'] ?? null;
        $newDescription = $data['newDescription'] ?? null;

        $categoriesToAttach = $data['categoriesToAttach'];
        $categoriesModels = new Collection();

        try {
            DB::beginTransaction();

            if(!empty($categoriesToAttach)) {
                $categoriesModels = Recipe::whereIn('id', $categoriesToAttach)->get();
            }
    
            $newRecipe = Recipe::findOrFail($id);
            $newRecipe->name            = $newName;
            $newRecipe->kcal            = $newKcal;
            $newRecipe->price           = $newPrice;
            $newRecipe->description     = $newDescription;
            $newRecipe->url             = $newUrl;

            if($newServings) {
                $newRecipe->servings        = $newServings;
            }
            
            $newRecipe->save();
    
            $newRecipe->categories()->sync($categoriesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
