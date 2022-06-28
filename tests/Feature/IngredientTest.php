<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    public function testTitlesedNameFormat()
    {
        $expectedName = "Tortilla De Patata";

        $newIngredientName = "tortilla de patata";

        $createdModel = Ingredient::createOrGetIngredient($newIngredientName);

        $this->assertEquals($expectedName, $createdModel->name);
    }

    public function testLowerisedNameFormat()
    {
        $expectedName = "Tortilla De Patata";

        $newIngredientName = "TORTILLA DE PATATA";

        $createdModel = Ingredient::createOrGetIngredient($newIngredientName);

        $this->assertEquals($expectedName, $createdModel->name);
    }

    public function testTrimmedNameFormat()
    {
        $expectedName = "Tortilla De Patata";

        $newIngredientName = "tortilla      de   patata";

        $createdModel = Ingredient::createOrGetIngredient($newIngredientName);

        $this->assertEquals($expectedName, $createdModel->name);
    }

    public function testSingularisedNameFormat()
    {
        $expectedName = "Tortilla De Patata";

        $newIngredientName = "tortilla      de   patata";

        $createdModel = Ingredient::createOrGetIngredient($newIngredientName);

        $this->assertEquals($expectedName, $createdModel->name);
    }

    public function testNotCreationOfSimilarIngredient()
    {
        $expectedModel = Ingredient::factory()->create([
            'name' => "Tortilla De Patata"
        ]);

        $newIngredientName = "tortilla      de   patata";

        $obtainedModel = Ingredient::createOrGetIngredient($newIngredientName);

        $this->assertEquals($expectedModel->id, $obtainedModel->id);
    }
}
