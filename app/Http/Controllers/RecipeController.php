<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::orderBy('name')->get();

        return view('recipes', [
            'tableTitle' => 'Todas las recetas',
            'recipes' => $recipes
        ]);

    }
}
