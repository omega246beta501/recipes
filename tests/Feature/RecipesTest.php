<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipesTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();

    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRecipesWithContradictoryIncludedAndExcludedCategories()
    {
        $this->recipes = Recipe::factory()
                                ->has(Category::factory()->count(2))
                                ->count(5)
                                ->create();

        $categoryToBeIncluded = $this->recipes->first()->categories[0]->id;
        $categoryToBeExcluded = $this->recipes->first()->categories[1]->id;

        $expectedRecipes = new Collection();
        $obtainedRecipes = Recipe::randomRecipes([], [$categoryToBeIncluded], [$categoryToBeExcluded], 6);

        $this->assertEquals($expectedRecipes, $obtainedRecipes);
    }

    public function testRecentlyUsedRecipesShouldNotBeShown() {
        $this->recipes = Recipe::factory()
                                ->count(10)
                                ->sequence(
                                    ['last_used_at' => Recipe::$DEFAULT_DATE],
                                    ['last_used_at' => date(now())] 
                                )
                                ->create();
        
        $expectedRecipesCount = 5;
        $obtainedRecipesCount = Recipe::randomRecipes()->count();

        $this->assertEquals($expectedRecipesCount, $obtainedRecipesCount);
    }

    public function testRecentlyUsedRecipesWithCategoriesShouldNotBeShown() {
        $this->recipes = Recipe::factory()
                                ->has(Category::factory()->count(2))
                                ->count(10)
                                ->sequence(
                                    ['last_used_at' => Recipe::$DEFAULT_DATE],
                                    ['last_used_at' => date(now())] 
                                )
                                ->create();
        
        $expectedRecipesCount = 5;
        $obtainedRecipesCount = Recipe::randomRecipes()->count();

        $this->assertEquals($expectedRecipesCount, $obtainedRecipesCount);
    }

    public function testKeepedRecipes() {
        $this->recipes = Recipe::factory()
                                ->count(10)
                                ->create();
        
        $initialGeneratedMenu = Recipe::randomRecipes();
        $keepedRecipe = $initialGeneratedMenu->random();
        $secondGeneratedMenu = Recipe::randomRecipes([$keepedRecipe->id]);

        $expectedRecipeToBeInMenu = $keepedRecipe;
        $obtainedResult = $secondGeneratedMenu->contains($expectedRecipeToBeInMenu);

        $this->assertTrue($obtainedResult);
    }
}
