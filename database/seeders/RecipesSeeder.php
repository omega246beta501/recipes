<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class RecipesSeeder extends Seeder
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
        
        $recipe = new \App\Models\Recipe([
            'name' => 'Patatas y carne'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Lentejas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::LEGUMBRES);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Gurullos'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::MATRIARCA);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::LEGUMBRES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Ajopollo'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::MATRIARCA);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Arroz blanco'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::VEGANA);
        $recipe->categories()->attach(Category::VEGETARIANA);
        $recipe->categories()->attach(Category::ARROCES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo al curry'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::INDIA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo con nata'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Estofado de ternera'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::TERNERA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Arroz a la cubana'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::ARROCES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Arroz frito'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::CHINA);
        $recipe->categories()->attach(Category::ARROCES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pizza'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ITALIANA);
        $recipe->categories()->attach(Category::GORDACO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Quiché'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::PICNIC);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pastel de cebolla'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::PICNIC);
        $recipe->categories()->attach(Category::ITALIANA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Trenza'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::PICNIC);

        $recipe = new \App\Models\Recipe([
            'name' => 'Empanada'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::PICNIC);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Empanadillas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::PICNIC);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'BBQ\'s Shepherd\'s pie'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::SUPERPILOPI);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::GORDACO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Lasaña'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ITALIANA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo a la cerveza'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::SUPERPILOPI);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pastel de berenjena'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);

        $recipe = new \App\Models\Recipe([
            'name' => 'Bacon Swirls'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::PICNIC);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Crepes'
        ]);
        $recipe->save();

        $recipe = new \App\Models\Recipe([
            'name' => 'Sandwiches al horno'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::PICNIC);
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Fideuá'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::PESCAO);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Quesadillas de mi hermana'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::PICNIC);

        $recipe = new \App\Models\Recipe([
            'name' => 'Berenjenas rellenas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::SUPERPILOPI);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo Strogonoff'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::TERNERA);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo al horno'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::POLLO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pisto'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::VEGETARIANA);
        $recipe->categories()->attach(Category::VEGANA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Ensaladilla rusa'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::PESCAO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Cocido'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::MATRIARCA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Puré de verduras'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::VEGANA);
        $recipe->categories()->attach(Category::VEGETARIANA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Vichyssoise'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::VEGANA);
        $recipe->categories()->attach(Category::VEGETARIANA);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::PENDIENTES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Tapaditos'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::PENDIENTES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Marmitaco'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::PESCAO);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Carne a la pimienta'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Masterchef Wok (bimi)'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::CHINA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo en ajo cabañil'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::PENDIENTES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Huevos rellenos'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::PENDIENTES);

        $recipe = new \App\Models\Recipe([
            'name' => 'Flamenquines'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);


        $recipe = new \App\Models\Recipe([
            'name' => 'Cordon Bleu'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::GORDACO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Sopa de Pollo'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::LEGUMBRES);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Puré carné y brócolí'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::FACIL);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::CERDO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Noodles'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::CHINA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Fajitas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::MEXICANA);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Albóndigas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::CERDO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Croquetas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::SUPERPILOPI);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Carne en salsa'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ESPAÑOLA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Asao de la abuela Julia'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::TERNERA);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::JUANAN);

        $recipe = new \App\Models\Recipe([
            'name' => 'Macarrones al horno de Juan'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::FAVORITAS_MARTA);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::JUANAN);
        $recipe->categories()->attach(Category::PASTA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Macarrones de la abuela'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::FAVORITAS_RUBEN);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::PASTA);
        $recipe->categories()->attach(Category::ADELI);

        $recipe = new \App\Models\Recipe([
            'name' => 'Espaguetis carbonara'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::ITALIANA);
        $recipe->categories()->attach(Category::PASTA);
        $recipe->categories()->attach(Category::SUPERPILOPI);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Ramen'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::HEALTHY);
        $recipe->categories()->attach(Category::SOPAS);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::JAPONESA);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo empanao'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::POLLO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Hamburguesas'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Coditos con bechamel'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::PASTA);
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Ternera china'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::TERNERA);
        $recipe->categories()->attach(Category::CHINA);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Biscotas con bechamel'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ADELI);
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Macarrones con chorizo'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::PASTA);
        $recipe->categories()->attach(Category::FACIL);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pollo Teriyaki'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::POLLO);
        $recipe->categories()->attach(Category::CHINA);
        $recipe->categories()->attach(Category::SUPERPILOPI);

        $recipe = new \App\Models\Recipe([
            'name' => 'Pan relleno de sofrito'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::CERDO);
        $recipe->categories()->attach(Category::ADELI);

        $recipe = new \App\Models\Recipe([
            'name' => 'Camembert frito'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::GORDACO);
        $recipe->categories()->attach(Category::LACTOSA);
        $recipe->categories()->attach(Category::VEGETARIANA);

        $recipe = new \App\Models\Recipe([
            'name' => 'Paella al estilo Marta'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ARROCES);
        $recipe->categories()->attach(Category::ESPAÑOLA);
        $recipe->categories()->attach(Category::POLLO);

        $recipe = new \App\Models\Recipe([
            'name' => 'Risotto'
        ]);
        $recipe->save();
        $recipe->categories()->attach(Category::ARROCES);
        $recipe->categories()->attach(Category::ITALIANA);
        $recipe->categories()->attach(Category::SUPERPILOPI);
        $recipe->categories()->attach(Category::VEGETARIANA);
        $recipe->categories()->attach(Category::LACTOSA);

        





        




    }
}
