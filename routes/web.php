<?php

use Illuminate\Support\Facades\Route;
use App\Data\Routes\CategoryRoutes;
use App\Data\Routes\IngredientRoutes;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/', 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('home');
Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('menu');
Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes')->middleware(['auth'])->name('regenerateRecipes');
Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu')->middleware(['auth'])->name('createMenu');
Route::get(MenuRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu')->middleware(['auth'])->name('discardMenu');
Route::get(MenuRoutes::NEW_MENU, 'App\Http\Controllers\Controller@clearMenu')->middleware(['auth'])->name('newMenu');

// CATEGORIES
Route::get(CategoryRoutes::CATEGORIES, 'App\Http\Controllers\CategoryController@index')->middleware(['auth'])->name('categories');
Route::put(CategoryRoutes::PUT_CATEGORY, 'App\Http\Controllers\CategoryController@store')->middleware(['auth'])->name('putCategory');
Route::get(CategoryRoutes::RECIPES_BY_CATEGORY, 'App\Http\Controllers\CategoryController@recipesByCategory')->middleware(['auth'])->name('recipesByCategory');
Route::get(CategoryRoutes::UPDATE_VIEW, 'App\Http\Controllers\CategoryController@updateView')->middleware(['auth'])->name('updateCategoryView');
Route::get(CategoryRoutes::POPULATE_CATEGORY, 'App\Http\Controllers\CategoryController@populateCategory')->middleware(['auth'])->name('populateCategory');

// RECIPES
Route::get('/test', 'App\Http\Controllers\RecipeController@newRecipes')->middleware(['auth'])->name('newRecipes');
Route::get('/test/{id}', 'App\Http\Controllers\RecipeController@viewRecipe')->middleware(['auth'])->name('newViewRecipe');
Route::get('/test-instructions/{id}', 'App\Http\Controllers\RecipeController@viewRecipeInstructions')->middleware(['auth'])->name('viewRecipeInstructions');
Route::get(RecipeRoutes::RECIPES, 'App\Http\Controllers\RecipeController@index')->middleware(['auth'])->name('recipes');
Route::post(RecipeRoutes::UPDATE, 'App\Http\Controllers\RecipeController@update')->middleware(['auth'])->name('updateRecipe');
Route::post(RecipeRoutes::NEW_RECIPE, 'App\Http\Controllers\RecipeController@store')->middleware(['auth'])->name('newRecipe');
Route::get(RecipeRoutes::UPDATE_VIEW, 'App\Http\Controllers\RecipeController@updateView')->middleware(['auth'])->name('updateRecipeView');

// INGREDIENTS
Route::post(IngredientRoutes::ATTACH_RECIPE, 'App\Http\Controllers\IngredientController@attachRecipe')->middleware(['auth'])->name('attachRecipe');
Route::post(IngredientRoutes::DETACH_RECIPE, 'App\Http\Controllers\IngredientController@detachRecipe')->middleware(['auth'])->name('detachRecipe');
Route::get(IngredientRoutes::QUERY_INGREDIENTS, 'App\Http\Controllers\IngredientController@queryIngredients')->middleware(['auth'])->name('queryIngredients');
Route::post(IngredientRoutes::UPDATE_ATTACHED, 'App\Http\Controllers\IngredientController@updateAttachedRecipe')->middleware(['auth'])->name('updateAttachedRecipe');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/kk', 'App\Http\Controllers\CategoryController@indexVue');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';