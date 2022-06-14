<?php

namespace App\Http\Controllers;

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
        // $data = $request->json()->all();
        Log::info("recetas");

        $recipes = \App\Models\Recipe::randomRecipes([], [], [], 6);

        return view('prueba', [
            'recipes' => $recipes
        ]);
    }

    public function regenerateRecipes(Request $request) {
        $data = $request->json()->all();
        $keepedRecipesIds = $data['keepedRecipesIds'];
        Log::info($keepedRecipesIds);
        $recipes = \App\Models\Recipe::randomRecipes($keepedRecipesIds, [], [], 6);

        return view('prueba', [
            'recipes' => $recipes,
            'keepedRecipesIds' => $keepedRecipesIds
        ]);
    }
}
