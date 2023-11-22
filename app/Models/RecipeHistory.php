<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeHistory extends Model
{
    use HasFactory;

    protected $table = 'recipes_history';
    public $timestamps = false;
    
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
