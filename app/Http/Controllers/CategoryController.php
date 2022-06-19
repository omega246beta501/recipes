<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('recipes')
                                ->orderBy('recipes_count', 'desc')
                                ->get();

        return view('categories', [
            'categories' => $categories
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

        return view('recipesByCategory', [
            'category' => $category,
            'recipes' => $recipes
        ]);
    }
}
