<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipesTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();

        $this->recipes = Recipe::factory()
                                ->has(Category::factory()->count(2))
                                ->count(5)
                                ->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRecipesWithContradictoryIncludedAndExcludedCategories()
    {
        $categoryToBeIncluded = $this->recipes->first()->categories[0]->id;
        $categoryToBeExcluded = $this->recipes->first()->categories[1]->id;

        $expectedRecipes = array();
        $obtainedRecipes = Recipe::randomRecipes([], [$categoryToBeIncluded], [$categoryToBeExcluded], 6);

        $this->assertEquals($expectedRecipes, $obtainedRecipes);

       


    }
}
