<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShoppingList extends Model
{
    use HasFactory;

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'ingredient_lists', 'list_id')
        ->withPivot('description')
        ->withTimestamps();
    }

    public function emptyList() {
        $this->ingredients()->detach();
    }

    private function formatElementDescription($recipe) {
        if(empty($recipe->pivot->qty) && empty($recipe->pivot->description)) {
            return $recipe->name;
        }
        if(empty($recipe->pivot->qty)) {
            return $recipe->name . ':(' . $recipe->pivot->description .')';
        }
        if(empty($recipe->pivot->description)) {
            return $recipe->name . ':' . $recipe->pivot->qty;
        }

        return $recipe->name . ':' . $recipe->pivot->qty . ' (' . $recipe->pivot->description . ')';
    }

    public function createShoppingList() {
        $this->emptyList();
        
        $inMenuIngredients = Ingredient::whereHas('recipes', function($query) {
            $query->where('is_in_menu', 1)
                  ->where('user_id', Auth::id());
        })->get();

        $shoppingListElements = array();

        $i = 0;
        foreach ($inMenuIngredients as $ingredient) {
            $recipesInMenu = $ingredient->recipes()->where('is_in_menu', 1)->where('user_id', Auth::id())->get();
            $shoppingListElements[$i]['id'] = $ingredient->id;

            $elementDescriptions = array();
            foreach ($recipesInMenu as $recipe) {
                $elementDescriptions[] = $this->formatElementDescription($recipe);
            }

            $shoppingListElements[$i]['description'] = implode(',', $elementDescriptions);
            $i++;
        }

        $shoppingListElements = json_decode(json_encode($shoppingListElements), false);

        foreach ($shoppingListElements as $element) {
            $this->ingredients()->attach($element->id, ['description' => $element->description]);
        }

        // $inMenuIngredients = DB::table('recipes')
        //                         ->join('recipe_ingredient', 'recipe_ingredient.recipe_id', '=', 'recipes.id')
        //                         ->join('ingredients', 'recipe_ingredient.ingredient_id', '=', 'ingredients.id')
        //                         ->select(DB::raw("ingredients.id, group_concat(recipes.name, ':', recipe_ingredient.qty, ' ', recipe_ingredient.description) as description"))
        //                         // ->where('recipes.is_in_menu', 1)
        //                         ->groupBy('ingredients.name')
        //                         ->get();
        
        // foreach ($inMenuIngredients as $ingredient) {
        //     $shoppingList->ingredients()->attach($ingredient->id, ['description' => $ingredient->description]);
        // }
    }
}
