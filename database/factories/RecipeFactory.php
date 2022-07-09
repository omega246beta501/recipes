<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{

    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->numerify('Recipe - ###'),
            'description' => $this->faker->text()
        ];
    }

    public function inMenu() {
        return $this->state(function (array $attributes) {
            return [
                'is_in_menu' => true
            ];
        });
    }
}
