<?php

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

Route::get('/recipes', 'App\Http\Controllers\Controller@randomRecipes');
Route::post('/recipes/regenerate', 'App\Http\Controllers\Controller@regenerateRecipes');
Route::post('/recipes/include', 'App\Http\Controllers\Controller@includeRecipesInMenu');
Route::get('/recipes/clearMenu', 'App\Http\Controllers\Controller@discardMenu');