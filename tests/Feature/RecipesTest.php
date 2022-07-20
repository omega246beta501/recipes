<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipesTest extends TestCase
{
    use DatabaseTransactions;
    
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
        $obtainedRecipes = Recipe::randomRecipes([], [$categoryToBeIncluded], [$categoryToBeExcluded], [], 6);

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

    public function testRecipesWithIncludedCategories()
    {
        $this->recipes = Recipe::factory()
                                ->has(Category::factory()->count(2))
                                ->count(5)
                                ->create();

        $categoryToBeIncluded = $this->recipes->first()->categories[0]->id;

        $expectedRecipe = $this->recipes->first();
        $obtainedRecipes = Recipe::randomRecipes([], [$categoryToBeIncluded], [], [], 6);

        $this->assertCount(1, $obtainedRecipes);
        $obtainedRecipe = $obtainedRecipes->first();
        $this->assertEquals($expectedRecipe->id, $obtainedRecipe->id);
    }

    public function testRecipesWithExcludedCategories()
    {
        $this->recipes = Recipe::factory()
                                ->has(Category::factory()->count(2))
                                ->count(5)
                                ->create();

        $categoryToBeExcluded = $this->recipes->first()->categories[0]->id;

        $expectedRecipe = $this->recipes->first();
        $obtainedRecipes = Recipe::randomRecipes([], [], [$categoryToBeExcluded], [], 6);

        $this->assertCount(4, $obtainedRecipes);
    }

    public function testMatchingRecipesByIngredientsTwoInCommon()
    {
        $this->recipes = Recipe::factory()
                                ->count(3)
                                ->create();

        $sopa = $this->recipes->first();
        $ramen = $this->recipes->get(1);
        $cocido = $this->recipes->last();

        $pollo = Ingredient::factory()->create([
            'name' => 'Pollo',
        ]);

        $zanahoria = Ingredient::factory()->create([
            'name' => 'Zanahoria',
        ]);

        $sopa->ingredients()->attach($pollo);
        $cocido->ingredients()->attach($pollo);
        $ramen->ingredients()->attach($pollo);

        $sopa->ingredients()->attach($zanahoria);
        $cocido->ingredients()->attach($zanahoria);

        $expectedRecipes = new Collection([$sopa, $cocido]);
        $obtainedRecipes = Recipe::randomRecipes([], [], [], [$pollo->id, $zanahoria->id], 6);

        $this->assertEquals($expectedRecipes->sortBy('id')->pluck('id'), $obtainedRecipes->sortBy('id')->pluck('id'));
    }

    public function testMatchingRecipesByIngredientsOneInCommon()
    {
        $this->recipes = Recipe::factory()
                                ->count(3)
                                ->create();

        $sopa = $this->recipes->first();
        $ramen = $this->recipes->get(1);
        $cocido = $this->recipes->last();

        $pollo = Ingredient::factory()->create([
            'name' => 'Pollo',
        ]);

        $zanahoria = Ingredient::factory()->create([
            'name' => 'Zanahoria',
        ]);

        $sopa->ingredients()->attach($pollo);
        $cocido->ingredients()->attach($pollo);
        $ramen->ingredients()->attach($pollo);

        $sopa->ingredients()->attach($zanahoria);
        $cocido->ingredients()->attach($zanahoria);

        $expectedRecipes = new Collection([$sopa, $cocido, $ramen]);
        $obtainedRecipes = Recipe::randomRecipes([], [], [], [$pollo->id], 6);
        //assert two sorted collections are equal
        $this->assertEquals($expectedRecipes->sortBy('id')->pluck('id'), $obtainedRecipes->sortBy('id')->pluck('id'));
    }
}
