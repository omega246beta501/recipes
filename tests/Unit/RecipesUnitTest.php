<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipesUnitTest extends TestCase
{
    use DatabaseTransactions;
    
    protected function setUp(): void {
        parent::setUp();

    }

    //teardown
    protected function tearDown(): void {
        parent::tearDown();
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
        $obtainedRecipes = Recipe::recipesWithIngredients([$pollo->id, $zanahoria->id]);

        $this->assertEquals($expectedRecipes->sortBy('id')->pluck('id'), $obtainedRecipes->sortBy('id')->pluck('id'));
    }
    
    
}
