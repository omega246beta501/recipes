<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Recipe;
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

    public function store(Request $request) {
        $data = RequestHelper::requestToArray($request);
        
        $newName        = $data['newName'];
        $newKcal        = $data['newKcal'] ?? null;
        $newPrice       = $data['newPrice'] ?? null;
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
            $newRecipe->save();
    
            $newRecipe->categories()->attach($categoriesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
