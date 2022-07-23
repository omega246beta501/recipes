<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CategoryRecipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Recipe extends Model
{
    use HasFactory;
    
    public static $DEFAULT_DATE = '1979-12-31';

    public $timestamps = false;

    protected function kcal(): Attribute {
        return Attribute::make(
            set: fn ($value) => FormatHelper::nullIfEmpty($value)
        );
    }

    protected function price(): Attribute {
        return Attribute::make(
            set: fn ($value) => FormatHelper::nullIfEmpty($value)
        );
    }
    
    /**
     * The categories that belong to the Recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_recipes');
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipes')
        ->withPivot('description')
        ->withTimestamps();
    }
    private static function queryCategories($query, $includedCategories, $excludedCategories) {
        if(!empty($includedCategories) || !empty($excludedCategories)) {
            if(!empty($includedCategories)) {
                $query->whereIn('id', function($q) use ($includedCategories) {
                    $q->select('recipe_id')
                        ->from('category_recipes')
                        ->whereIn('category_id', $includedCategories);
                });
            }
            if(!empty($excludedCategories)) {
                $query->whereNotIn('id', function($q) use ($excludedCategories) {
                    $q->select('recipe_id')
                        ->from('category_recipes')
                        ->whereIn('category_id', $excludedCategories);
                });
            }
        }
    }

    private static function queryLastUsedAt($query) {
        $query->where(DB::raw('DATEDIFF(CURDATE(), last_used_at)'), '>=', 14);
    }

    private static function queryRecipesWithIngredients($query, $withIngredients) {
        if(!empty($withIngredients)) {
            foreach ($withIngredients as $ingredient) {
                $query->whereIn('recipes.id', function($q) use ($ingredient){
                    $q->select('recipe_id')
                        ->from('ingredient_recipes')
                        ->where('ingredient_id', $ingredient);
                });
            }
        }
        return $query;
    }

    public static function randomRecipes(array $includedRecipes = [], array $includedCategories = [], array $excludedCategories = [], array $withIngredients = [], int $amount = 6) {
        Log::info($includedRecipes);
        $amountIncluded = count($includedRecipes);
        $amount = $amount - $amountIncluded;
        $included = Recipe::whereIn('id', $includedRecipes)->get();

        $recipes = Recipe::where(function($q) use ($includedCategories, $excludedCategories, $includedRecipes) {
            self::queryCategories($q, $includedCategories, $excludedCategories);

            self::queryLastUsedAt($q);

            if(!empty($includedRecipes)) {
                $q = $q->whereNotIn('id', $includedRecipes);
            }
        });

        $recipes = self::queryRecipesWithIngredients($recipes, $withIngredients);

        $recipes = $recipes->inRandomOrder()
        ->limit($amount)
        ->orderBy('name')
        ->get();

        $all = $included->merge($recipes)->sortBy('name');

        return $all;
    }

    public static function includedInMenu() {
        return Recipe::where('is_in_menu', true)->get();
    }

    public function includeInMenu() {
        $this->last_used_at = Carbon::now();
        $this->is_in_menu = true;
        $this->save();
    }

    public static function clearMenu() {
        $recipesInMenu = Recipe::includedInMenu();

        foreach ($recipesInMenu as $recipe) {
            $recipe->is_in_menu = false;
            $recipe->save();
        }
    }

    public static function discardMenu() {
        $recipesInMenu = Recipe::includedInMenu();

        foreach ($recipesInMenu as $recipe) {
            $recipe->is_in_menu = false;
            $recipe->last_used_at = Recipe::$DEFAULT_DATE;
            $recipe->save();
        }
    }

    public static function createShoppingList() {
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingList->emptyList();
        
        $inMenuIngredients = DB::table('recipes')
                                ->join('ingredient_recipes', 'ingredient_recipes.recipe_id', '=', 'recipes.id')
                                ->join('ingredients', 'ingredient_recipes.ingredient_id', '=', 'ingredients.id')
                                ->select(DB::raw("ingredients.id, group_concat(recipes.name, ':', ingredient_recipes.description) as description"))
                                ->where('recipes.is_in_menu', 1)
                                ->groupBy('ingredients.name')
                                ->get();
        
        foreach ($inMenuIngredients as $ingredient) {
            $shoppingList->ingredients()->attach($ingredient->id, ['description' => $ingredient->description]);
        }
    }

    public static function recipesWithIngredients(array $ingredients) {
        $recipes = DB::table('recipes');
        
        foreach ($ingredients as $ingredient) {
            $recipes->whereIn('recipes.id', function($q) use ($ingredient){
                $q->select('recipe_id')
                    ->from('ingredient_recipes')
                    ->where('ingredient_id', $ingredient);
            });
        }

        return $recipes->get();
    }
}
