<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'ingredient_lists', 'list_id')
        ->withPivot(['description', 'qty'])
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
        
        $menu = Menu::find(1);
        $inMenuRecipes = $menu->recipes;

        $inMenuIngredients = Ingredient::whereHas('recipes', function($query) use ($inMenuRecipes) {
            $query->whereIn('id', $inMenuRecipes->pluck('id'));
        })->get();

        $shoppingListElements = array();

        $i = 0;
        foreach ($inMenuIngredients as $ingredient) {
            $recipesInMenu = $ingredient->recipes()->whereIn('id', $inMenuRecipes->pluck('id'))->get();
            $shoppingListElements[$i]['id'] = $ingredient->id;

            $elementDescriptions = array();
            $ingredientQty = 0;
            foreach ($recipesInMenu as $recipe) {
                $elementDescriptions[] = $this->formatElementDescription($recipe);
                $ingredientQty  += $recipe->qty ?? 1;
            }

            $shoppingListElements[$i]['description'] = implode(',', $elementDescriptions);
            $shoppingListElements[$i]['qty'] = $ingredientQty;
            $i++;
        }

        $shoppingListElements = json_decode(json_encode($shoppingListElements), false);

        foreach ($shoppingListElements as $element) {
            $this->ingredients()->attach($element->id, ['description' => $element->description, 'qty' => $element->qty]);
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
