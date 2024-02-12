<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;

class Recipe extends Model
{
    use HasFactory;
    
    public static $DEFAULT_DATE = '1979-12-31';

    public $timestamps = false;

    protected $appends = ['last_used_at'];

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

    protected function lastUsedAt(): Attribute
    {
        return Attribute::make(
            get: function() {
                if($this->recipeLogs->count() > 0) {
                    return $this->recipeLogs()->latest('used_at')->first()->used_at;
                }
                else {
                    return null;
                }
            },
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

    public function recipeLogs()
    {
        return $this->hasMany(RecipeHistory::class);
    }

    public function recipeParts()
    {
        return $this->hasMany(RecipePart::class);
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
        ->using(RecipeIngredient::class)
        ->withPivot(['qty','description'])
        ->withTimestamps()
        ->orderBy('name');
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

    // private static function queryLastUsedAt($query) {
    //     $query->where(DB::raw('DATEDIFF(CURDATE(), last_used_at)'), '>=', 14);
    // }

    private static function queryRecipesWithIngredients($query, $withIngredients) {
        if(!empty($withIngredients)) {
            foreach ($withIngredients as $ingredient) {
                $query->whereIn('recipes.id', function($q) use ($ingredient){
                    $q->select('recipe_id')
                        ->from('recipe_ingredient')
                        ->where('ingredient_id', $ingredient);
                });
            }
        }
        return $query;
    }

    public static function randomRecipes(array $includedCategories = [], array $excludedCategories = [], array $withIngredients = [], int $amount = 6, array $searchedRecipes = []) {
        $menu = Menu::find(1);
        $includedRecipes = $menu->recipes;

        Log::info($includedRecipes);
        $amountIncluded = count($includedRecipes);
        $amount = $amount - $amountIncluded;

        $searched = Recipe::whereIn('id', $searchedRecipes)->get();

        $recipes = Recipe::where(function($q) use ($includedCategories, $excludedCategories, $includedRecipes) {
            self::queryCategories($q, $includedCategories, $excludedCategories);

            // self::queryLastUsedAt($q);

            if(!empty($includedRecipes)) {
                $q = $q->whereNotIn('id', $includedRecipes->pluck('id'));
            }
        });

        $recipes = self::queryRecipesWithIngredients($recipes, $withIngredients);

        $recipes = $recipes->inRandomOrder()
        ->limit($amount)
        ->orderBy('name')
        ->get();

        $all = $includedRecipes->merge($recipes)->merge($searched)->sortBy('name');

        return $all;
    }

    public static function includedInMenu() {
        $menu = Menu::find(1);
        return $menu->recipes;
    }

    public function includeInMenu() {
        $menu = Menu::find(1);

        $this->logUsedRecipe();
        $menu->recipes()->attach($this);
    }

    public static function logUsedRecipes(Collection $recipes) {
        foreach ($recipes as $recipe) {
            $recipe->logUsedRecipe();
        }
    }

    public static function recipesWithIngredients(array $ingredients) {
        $recipes = DB::table('recipes');
        
        foreach ($ingredients as $ingredient) {
            $recipes->whereIn('recipes.id', function($q) use ($ingredient){
                $q->select('recipe_id')
                    ->from('recipe_ingredient')
                    ->where('ingredient_id', $ingredient);
            });
        }

        return $recipes->get();
    }

    public function logUsedRecipe()
    {
        $historyLog = new RecipeHistory();
        $historyLog->recipe_id = $this->id;
        $historyLog->used_at = Carbon::now();
        $historyLog->save();
    }

    public function revertLastUsedAt()
    {
        $historyLog = $this->recipeLogs()->latest('used_at')->first();

        if($historyLog) {
            $historyLog->delete();
        }
    }
}
