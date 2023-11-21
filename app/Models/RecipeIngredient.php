<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipeIngredient extends Pivot
{
    use HasFactory;

    protected $table = 'recipe_ingredient';

    protected function qty(): Attribute {
        return Attribute::make(
            get: fn ($value) => FormatHelper::floatToIntQty($value),
            set: fn ($value) => FormatHelper::nullIfEmpty($value)
        );
    }

}
