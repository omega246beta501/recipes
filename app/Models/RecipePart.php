<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class RecipePart extends Model
{
    use HasFactory;

    protected $table = 'recipe_parts';
    

    public function recipes()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'part_id');
    }

}
