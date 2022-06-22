<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('recipes')
                                ->orderBy('recipes_count', 'desc')
                                ->get();

        $recipes = Recipe::orderBy('name')->get();

        return view('categories', [
            'categories' => $categories,
            'recipes'   => $recipes
        ]);
    }

    public function recipesByCategory($id) {
        $category= Category::find($id);

        $recipes = $category->recipes;

        foreach ($recipes as $recipe) {
            if($recipe->last_used_at == Recipe::$DEFAULT_DATE) {
                $recipe->last_used_at = 'Nunca';
            }
        }

        return view('recipes', [
            'tableTitle' => $category->name,
            'recipes' => $recipes
        ]);
    }

    public function store(Request $request) {
        $data = RequestHelper::requestToArray($request);
        
        $newName = $data['newName'];
        $recipesToAttach = $data['recipesToAttach'];

        if(!empty($recipesToAttach)) {
            $recipesModels = Recipe::whereIn('id', $recipesToAttach)->get();
        }

        $newCategory = new Category();
        $newCategory->name = $newName;
        $newCategory->save();

        $newCategory->recipes()->attach($recipesModels);
    }
}
