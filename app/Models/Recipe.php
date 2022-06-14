<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CategoryRecipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Recipe extends Model
{
    use HasFactory;

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
            $q->whereHas('categories', function($q) use ($includedCategories, $excludedCategories) {
                if(!empty($includedCategories)) {
                    $q = $q->whereIn('category_id', $includedCategories);
                }
                if(!empty($excludedCategories)) {
                    $q = $q->whereNotIn('category_id', $excludedCategories);
                }
            })
            ->where(DB::raw('DATEDIFF(CURDATE(), last_used_at)'), '>=', 14);

            if(!empty($includedRecipes)) {
                $q = $q->whereNotIn('id', $includedRecipes);
            }
        })
        ->inRandomOrder()
        ->limit($amount)
        ->orderBy('name')
        ->get();

        $all = $included->merge($recipes)->sortBy('name')->values()->all();

        return $all;

    }
}
