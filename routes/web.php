<?php

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

Route::get(RecipeRoutes::RECIPES, 'App\Http\Controllers\Controller@randomRecipes');
Route::post(RecipeRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes');
Route::post(RecipeRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu');
Route::get(RecipeRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu');