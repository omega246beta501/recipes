<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public static function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $category = new \App\Models\Category([
            'id' => 1,
            'name' => 'Sopas'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 2,
            'name' => 'Arroces'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 3,
            'name' => 'Healthy'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 4,
            'name' => 'Pasta'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 5,
            'name' => 'Gordaco'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 6,
            'name' => 'Dulce'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 7,
            'name' => 'Pollo'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 8,
            'name' => 'Ternera'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 9,
            'name' => 'Cerdo'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 10,
            'name' => 'Lactosa'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 11,
            'name' => 'Sin gluten'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 12,
            'name' => 'Vegana'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 13,
            'name' => 'Vegetariana'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 14,
            'name' => 'Legumbres'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 15,
            'name' => 'Fácil y rápido'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 16,
            'name' => 'China'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 17,
            'name' => 'Española'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 18,
            'name' => 'India'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 19,
            'name' => 'Japonesa'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 20,
            'name' => 'Italiana'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 21,
            'name' => 'Mexicana'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 22,
            'name' => 'Superpilopi'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 23,
            'name' => 'Picnic'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 24,
            'name' => 'Pescao'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 25,
            'name' => 'Favoritas Marta'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 26,
            'name' => 'Favoritas Rubén'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 27,
            'name' => 'Pendientes'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 28,
            'name' => 'Adeli'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 29,
            'name' => 'Carmen Matriarca'
        ]);
		$category->save();

        $category = new \App\Models\Category([
            'id' => 30,
            'name' => 'Juanan'
        ]);
		$category->save();
    }
}
