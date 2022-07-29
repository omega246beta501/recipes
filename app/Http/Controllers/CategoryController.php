<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::where('user_id', Auth::id())
                                ->withCount('recipes')
                                ->orderBy('recipes_count', 'desc')
                                ->get();

        $recipes = Recipe::where('user_id', Auth::id())->orderBy('name')->get();

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
            'recipes' => $recipes,
            'categories' => new Collection()
        ]);
    }

    public function store(Request $request) {
        $data = RequestHelper::requestToArray($request);
        
        $newName = $data['newName'];
        $recipesToAttach = $data['recipesToAttach'];
        $recipesModels = new Collection();

        try {
            DB::beginTransaction();

            if(!empty($recipesToAttach)) {
                $recipesModels = Recipe::whereIn('id', $recipesToAttach)->get();
            }
    
            $newCategory = new Category();
            $newCategory->name = $newName;
            $newCategory->user_id = Auth::id();
            $newCategory->save();
    
            $newCategory->recipes()->attach($recipesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function updateView($id) {

        $category = Category::findOrFail($id);
        $attachedRecipes = $category->recipes;
        $allRecipes = Recipe::where('user_id', Auth::id())->orderBy('name')->get();

        return view('components.forms.category', [
            'recipes' => $allRecipes,
            'attachedRecipes' => $attachedRecipes,
            'category' => $category
        ]);
    }

    public function update(Request $request) {

        $data = RequestHelper::requestToArray($request);
        
        $id             = $data['id'];
        $newName        = $data['newName'] ?? null;

        $recipesToAttach = $data['recipesToAttach'];
        $recipesModels = new Collection();

        try {
            DB::beginTransaction();

            if(!empty($recipesToAttach)) {
                $recipesModels = Recipe::whereIn('id', $recipesToAttach)->get();
            }
    
            $newCategory = Category::findOrFail($id);
            $newCategory->name            = $newName;
            $newCategory->save();
    
            $newCategory->recipes()->sync($recipesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
