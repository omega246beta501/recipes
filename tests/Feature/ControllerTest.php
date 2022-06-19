<?php

namespace Tests\Feature;

use App\Data\Routes\RecipeRoutes;
use App\Models\Category;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();

    }

    public function testIncludeRecipesInMenu() {
        $recipes = Recipe::factory()->count(10)->create();

        $recipeToInclude = $recipes->first();
        $data = [
            'recipesToInclude' => [$recipeToInclude->id]
        ];
        
        $this->post(MenuRoutes::CREATE_MENU, $data);

        $recipeToInclude->refresh();

        $expectedInMenuFlag = true;
        $expectedLastUsedAt = Carbon::now()->toDateString();
        $obtainedInMenuFlag = $recipeToInclude->is_in_menu;
        $obtainedLastUsedAt = $recipeToInclude->last_used_at;

        $this->assertEquals($expectedInMenuFlag, $obtainedInMenuFlag);
        $this->assertEquals($expectedLastUsedAt, $obtainedLastUsedAt);
    }

    public function testIncludeRecipesInMenuView() {
        $recipes = Recipe::factory()->count(10)->create();

        $recipesToInclude = $recipes->slice(0, 6);
        $data = [
            'recipesToInclude' => $recipesToInclude->pluck('id')->toArray()
        ];
        
        $response = $this->post(MenuRoutes::CREATE_MENU, $data);

        $expectedRecipesInView = $recipesToInclude;

        $response->assertViewHasAll([
            'recipes' => $expectedRecipesInView,
            'isMenuSet' => true
        ]);
        
    }
    
}
