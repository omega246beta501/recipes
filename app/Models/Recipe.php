<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CategoryRecipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Recipe extends Model
{
    use HasFactory;
    
    public static $DEFAULT_DATE = '1979-12-31';

    public $timestamps = false;
    /**
     * The categories that belong to the Recipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_recipes');
    }

    public static function randomRecipes(array $includedRecipes = [], array $includedCategories = [], array $excludedCategories = [], int $amount = 6) {
        Log::info($includedRecipes);
        $amountIncluded = count($includedRecipes);
        $amount = $amount - $amountIncluded;
        $included = Recipe::whereIn('id', $includedRecipes)->get();

        $recipes = Recipe::where(function($q) use ($includedCategories, $excludedCategories, $includedRecipes) {
            if(!empty($includedCategories) || !empty($excludedCategories)) {
                if(!empty($includedCategories)) {
                    $q->whereIn('id', function($q) use ($includedCategories) {
                        $q->select('recipe_id')
                            ->from('category_recipes')
                            ->whereIn('category_id', $includedCategories);
                    });
                }
                if(!empty($excludedCategories)) {
                    $q->whereNotIn('id', function($q) use ($excludedCategories) {
                        $q->select('recipe_id')
                            ->from('category_recipes')
                            ->whereIn('category_id', $excludedCategories);
                    });
                }
            }
            $q->where(DB::raw('DATEDIFF(CURDATE(), last_used_at)'), '>=', 14);

            if(!empty($includedRecipes)) {
                $q = $q->whereNotIn('id', $includedRecipes);
            }
        })
        ->inRandomOrder()
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
}
