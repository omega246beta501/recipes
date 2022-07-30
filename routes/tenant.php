<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Data\Routes\CategoryRoutes;
use App\Data\Routes\IngredientRoutes;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => ['web', InitializeTenancyByPath::class],
], function () {
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
    Route::get('/', 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('home');
    Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('menu');
    Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes')->middleware(['auth'])->name('regenerateRecipes');
    Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu')->middleware(['auth'])->name('createMenu');
    Route::get(MenuRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu')->middleware(['auth'])->name('discardMenu');
    Route::get(MenuRoutes::NEW_MENU, 'App\Http\Controllers\Controller@clearMenu')->middleware(['auth'])->name('newMenu');

    // CATEGORIES
    Route::get(CategoryRoutes::CATEGORIES, 'App\Http\Controllers\CategoryController@index')->middleware(['auth'])->name('categories');
    Route::post(CategoryRoutes::NEW_CATEGORY, 'App\Http\Controllers\CategoryController@store')->middleware(['auth'])->name('newCategory');
    Route::get(CategoryRoutes::RECIPES_BY_CATEGORY, 'App\Http\Controllers\CategoryController@recipesByCategory')->middleware(['auth'])->name('recipesByCategory');
    Route::get(CategoryRoutes::UPDATE_VIEW, 'App\Http\Controllers\CategoryController@updateView')->middleware(['auth'])->name('updateCategoryView');
    Route::post(CategoryRoutes::UPDATE, 'App\Http\Controllers\CategoryController@update')->middleware(['auth'])->name('updateCategory');

    // RECIPES
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
});
