<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function recipes() {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient')
                    ->using(RecipeIngredient::class)
                    ->withPivot(['qty', 'description'])
                    ->withTimestamps();
    }

    protected function name(): Attribute {
        return Attribute::make(
            set: fn ($value) => FormatHelper::ingredientNameFormat($value)
        );
    }
    
    public static function createOrGetIngredient(String $name) {

        $name = FormatHelper::ingredientNameFormat($name);
        $ingredient = Ingredient::where('name', $name)->where('user_id', Auth::id())->first();

        if($ingredient) {
            return $ingredient;
        }
        else {
            $newIngredient = new Ingredient();
            $newIngredient->name = $name;
            $newIngredient->user_id = Auth::id();
            $newIngredient->save();

            return $newIngredient;
        }

        return null;
    }
}
