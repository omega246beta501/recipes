<?php

use App\Api\MercadonaAPI;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Data\Routes\CategoryRoutes;
use App\Data\Routes\IngredientRoutes;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\SplitwiseController;
use App\Models\Recipe;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('home');
// Route::get('/1', 'App\Http\Controllers\Controller@newRandomRecipes')->middleware(['auth'])->name('home');
Route::get(MenuRoutes::MENU, 'App\Http\Controllers\Controller@randomRecipes')->middleware(['auth'])->name('menu');
Route::post(MenuRoutes::REGENERATE_RECIPES, 'App\Http\Controllers\Controller@regenerateRecipes')->middleware(['auth'])->name('regenerateRecipes');
Route::post(MenuRoutes::CREATE_MENU, 'App\Http\Controllers\Controller@closeMenu')->middleware(['auth'])->name('createMenu');
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
Route::get(IngredientRoutes::ALL_INGREDIENTS, [IngredientController::class, 'index'])->middleware(['auth'])->name('ingredientIndex');
Route::post(IngredientRoutes::MERCADONA_QUERY, [IngredientController::class, 'queryMercadonaProduct'])->middleware(['auth'])->name('mercadonaQuery');
Route::post(IngredientRoutes::ATTACH_MERCADONA_PRODUCT, [IngredientController::class, 'attachMercadonaProduct'])->middleware(['auth'])->name('attachMercadonaProduct');

// SHOPPING LIST
Route::get('/shopping_list', [ShoppingListController::class, 'index'])->middleware(['auth'])->name('shoppingList');

// SPLITWISE
Route::get('/splitwise/create_expense_view', [SplitwiseController::class, 'createExpenseView'])->middleware(['auth'])->name('createExpenseView');
Route::post('/splitwise/create_expense', [SplitwiseController::class, 'createExpense'])->middleware(['auth'])->name('createExpense');
Route::get('/splitwise/list_groups', [SplitwiseController::class, 'listGroups'])->middleware(['auth'])->name('listGroups');
Route::get('/splitwise/list_categories', [SplitwiseController::class, 'listCategories'])->middleware(['auth'])->name('listCategories');
Route::get('/splitwise/list_members', [SplitwiseController::class, 'listMembers'])->middleware(['auth'])->name('listMembers');

Route::get('/login', function () {
    return view('login');
})->name('login');

// Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/kk', 'App\Http\Controllers\CategoryController@indexVue');

Route::get('/mojon', function() {
    return Inertia::render('BarcodeScanner');
});

require __DIR__.'/auth.php';
