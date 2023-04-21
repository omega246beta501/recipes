<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Http\Resources\LiteRecipeCollection;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
            'recipes' => $recipes,
            'categories' => new Collection()
        ]);
    }

    public function store($id = null, Request $request) {
        $data = RequestHelper::requestToArray($request);
        
        $newName = $data['newName'];
        $recipesToAttach = $data['recipesToAttach'];
        $recipesModels = new Collection();

        try {
            DB::beginTransaction();

            if(!empty($recipesToAttach)) {
                $recipesModels = Recipe::whereIn('id', $recipesToAttach)->get();
            }
    
            $category = Category::findOrNew($id);
            $category->name = $newName;
            $category->save();
    
            $category->recipes()->sync($recipesModels);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function updateView($id) {

        $category = Category::findOrFail($id);
        $attachedRecipes = $category->recipes;
        $allRecipes = Recipe::orderBy('name')->get();

        return view('components.forms.category', [
            'recipes' => $allRecipes,
            'attachedRecipes' => $attachedRecipes,
            'category' => $category
        ]);
    }

    public function populateCategory($id) {

        $category = Category::findOrFail($id);
        $attachedRecipes = new LiteRecipeCollection($category->recipes);

        return [
            'attachedRecipes' => $attachedRecipes,
            'category' => $category->withoutRelations(),
            'storeUrl' =>  route('putCategory', ['tenant' => tenant(), 'id' => $id])
        ];
    }

    public function indexVue() {
        $categories = Category::withCount('recipes')
                                ->with('recipes')
                                ->orderBy('recipes_count', 'desc')
                                ->get();

        $recipes = Recipe::orderBy('name')->get();
        
        return Inertia::render('Categories', [
            'categories' => $categories,
            'recipes'   => new LiteRecipeCollection($recipes),
            'categoriesUrls' => [
                'populateUrl' => route('populateCategory', ['tenant' => tenant()]),
                'putUrl' => route('putCategory', ['tenant' => tenant(), 'id' => 0]),
            ]
        ]);
    }
}
