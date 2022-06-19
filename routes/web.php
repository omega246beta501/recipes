<?php

use App\Data\Routes\CategoryRoutes;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes');
Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes');
Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu');
Route::get(MenuRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu');

// CATEGORIES
Route::get(CategoryRoutes::CATEGORIES, 'App\Http\Controllers\CategoryController@index');
Route::get(CategoryRoutes::RECIPES_BY_CATEGORY, 'App\Http\Controllers\CategoryController@recipesByCategory');