<?php

namespace App\Providers;

use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Log::info("Checking if the menu is outdated");

        $inMenuRecipe = Recipe::where('is_in_menu', true)->first();

        if($inMenuRecipe) {
            $assignedAt = $inMenuRecipe->last_used_at;
            $today = Carbon::now();
    
            $difference = $today->diffInDays($assignedAt);
    
            if($difference >= 7) {
                Recipe::clearMenu();
            }
        }
    }
}
