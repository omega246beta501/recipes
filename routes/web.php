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

Route::get('/', 'App\Http\Controllers\Controller@randomRecipes');
Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes');
Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes');
Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu');
Route::get(MenuRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu');

// CATEGORIES
Route::get(CategoryRoutes::CATEGORIES, 'App\Http\Controllers\CategoryController@index');
Route::post(CategoryRoutes::NEW_CATEGORY, 'App\Http\Controllers\CategoryController@store');
Route::get(CategoryRoutes::RECIPES_BY_CATEGORY, 'App\Http\Controllers\CategoryController@recipesByCategory');
Route::get(CategoryRoutes::UPDATE_VIEW, 'App\Http\Controllers\CategoryController@updateView');
Route::post(CategoryRoutes::UPDATE, 'App\Http\Controllers\CategoryController@update');

// RECIPES
Route::get(RecipeRoutes::RECIPES, 'App\Http\Controllers\RecipeController@index');
Route::post(RecipeRoutes::UPDATE, 'App\Http\Controllers\RecipeController@update');
Route::post(RecipeRoutes::NEW_RECIPE, 'App\Http\Controllers\RecipeController@store');
Route::get(RecipeRoutes::UPDATE_VIEW, 'App\Http\Controllers\RecipeController@updateView');