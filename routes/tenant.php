<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Data\Routes\CategoryRoutes;
use App\Data\Routes\IngredientRoutes;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
    Route::get('/', 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth']);
    Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth']);
    Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes')->middleware(['auth']);
    Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@includeRecipesInMenu')->middleware(['auth']);
    Route::get(MenuRoutes::DISCARD_MENU, 'App\Http\Controllers\Controller@discardMenu')->middleware(['auth']);
    Route::get(MenuRoutes::NEW_MENU, 'App\Http\Controllers\Controller@clearMenu')->middleware(['auth']);

    // CATEGORIES
    Route::get(CategoryRoutes::CATEGORIES, 'App\Http\Controllers\CategoryController@index')->middleware(['auth']);
    Route::post(CategoryRoutes::NEW_CATEGORY, 'App\Http\Controllers\CategoryController@store')->middleware(['auth']);
    Route::get(CategoryRoutes::RECIPES_BY_CATEGORY, 'App\Http\Controllers\CategoryController@recipesByCategory')->middleware(['auth']);
    Route::get(CategoryRoutes::UPDATE_VIEW, 'App\Http\Controllers\CategoryController@updateView')->middleware(['auth']);
    Route::post(CategoryRoutes::UPDATE, 'App\Http\Controllers\CategoryController@update')->middleware(['auth']);

    // RECIPES
    Route::get(RecipeRoutes::RECIPES, 'App\Http\Controllers\RecipeController@index')->middleware(['auth']);
    Route::post(RecipeRoutes::UPDATE, 'App\Http\Controllers\RecipeController@update')->middleware(['auth']);
    Route::post(RecipeRoutes::NEW_RECIPE, 'App\Http\Controllers\RecipeController@store')->middleware(['auth']);
    Route::get(RecipeRoutes::UPDATE_VIEW, 'App\Http\Controllers\RecipeController@updateView')->middleware(['auth']);

    // INGREDIENTS
    Route::post(IngredientRoutes::ATTACH_RECIPE, 'App\Http\Controllers\IngredientController@attachRecipe')->middleware(['auth']);
    Route::post(IngredientRoutes::DETACH_RECIPE, 'App\Http\Controllers\IngredientController@detachRecipe')->middleware(['auth']);
    Route::get(IngredientRoutes::QUERY_INGREDIENTS, 'App\Http\Controllers\IngredientController@queryIngredients')->middleware(['auth']);
    Route::post(IngredientRoutes::UPDATE_ATTACHED, 'App\Http\Controllers\IngredientController@updateAttachedRecipe')->middleware(['auth']);

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
