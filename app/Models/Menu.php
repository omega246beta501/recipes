<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InMenuRecipes;


class Menu extends Model
{
    use HasFactory;

    public function recipes() {
        return $this->belongsToMany(Recipe::class);
    }

    public function clearMenu() {
        $this->is_menu_locked = false;
        $this->save();
        $this->recipes()->detach();
    }

    public function discardMenu() {

        $recipes = $this->recipes;

        foreach ($recipes as $recipe) {
            $recipe->revertLastUsedAt();
            $recipe->save();
        }

        $this->clearMenu();
    }

    public function syncMenuRecipes(array $recipes) {
        $this->recipes()->sync($recipes);
    }
}