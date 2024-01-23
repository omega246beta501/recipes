<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class ShoppingListController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $shoppingList = ShoppingList::findOrFail(1);
        $shoppingListIngredients = $shoppingList->ingredients()->orderBy('name')->get();

        return Inertia::render('ShoppingList', ['list' => $shoppingListIngredients]);
    }
}
