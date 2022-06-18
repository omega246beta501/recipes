<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();

    }

    public function testRandomRecipes() {
        $recipes = Recipe::factory()->count(10)->create();

        
    }
    
}
