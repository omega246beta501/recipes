<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('recipes')
                                ->orderBy('recipes_count', 'desc')
                                ->get();

        return view('categories', [
            'categories' => $categories
        ]);
    }
}
