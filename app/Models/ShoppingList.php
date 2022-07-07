<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
