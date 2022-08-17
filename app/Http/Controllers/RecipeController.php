<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\View\Components\Forms\Recipe as FormsRecipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('recipes', [
            'tableTitle' => 'Todas las recetas',
            'recipes' => $recipes,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $data = RequestHelper::requestToArray($request);

        $id             = $data['id'];
        $newName        = $data['name'];
        $newUrl         = $data['url'] ?? null;
        $newKcal        = $data['kcal'] ?? null;
        $newPrice       = $data['price'] ?? null;
        $newDescription = $data['description'] ?? null;
        $ingredients    = $data['ingredients'] ?? [];

        // $categoriesToAttach = $data['categoriesToAttach'];
        // $categoriesModels = new Collection();

        try {
            DB::beginTransaction();

            // if(!empty($categoriesToAttach)) {
            //     $categoriesModels = Recipe::whereIn('id', $categoriesToAttach)->get();
            // }

            $recipe = Recipe::findOrNew($id);
            $recipe->name            = $newName;
            $recipe->kcal            = $newKcal;
            $recipe->price           = $newPrice;
            $recipe->description     = $newDescription;
            $recipe->url             = $newUrl;
            $recipe->save();

            // $recipe->categories()->attach($categoriesModels);
            $recipe->ingredients()->detach();
            foreach ($ingredients as $ingredient) {
                $name = $ingredient['name'];
                $qty  = $ingredient['qty'] ?? null;
                $ingredientDescription = $ingredient['description'] ?? null;

                $ingredient = Ingredient::createOrGetIngredient($name);

                $recipe->ingredients()->detach($ingredient);
                $recipe->ingredients()->attach($ingredient, ["qty" => $qty, "description" => $ingredientDescription]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function updateView($id)
    {

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

    public function update(Request $request)
    {

        $data = RequestHelper::requestToArray($request);

        $id             = $data['id'];
        $newUrl         = $data['newUrl'] ?? null;
        $newName        = $data['newName'] ?? null;
        $newKcal        = $data['newKcal'] ?? null;
        $newPrice       = $data['newPrice'] ?? null;
        $newDescription = $data['newDescription'] ?? null;

        $categoriesToAttach = $data['categoriesToAttach'];
        $categoriesModels = new Collection();

        try {
            DB::beginTransaction();

            if (!empty($categoriesToAttach)) {
                $categoriesModels = Recipe::whereIn('id', $categoriesToAttach)->get();
            }

            $newRecipe = Recipe::findOrFail($id);
            $newRecipe->name            = $newName;
            $newRecipe->kcal            = $newKcal;
            $newRecipe->price           = $newPrice;
            $newRecipe->description     = $newDescription;
            $newRecipe->url             = $newUrl;
            $newRecipe->save();

            $newRecipe->categories()->sync($categoriesModels);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
