<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Category extends Model
{
    use HasFactory;

    const SOPAS = 1;
    const ARROCES = 2;
    const HEALTHY = 3;
    const PASTA = 4;
    const GORDACO = 5;
    const DULCE = 6;
    const POLLO = 7;
    const TERNERA = 8;
    const CERDO = 9;
    const LACTOSA = 10;
    const SIN_GLUTEN = 11;
    const VEGANA = 12;
    const VEGETARIANA = 13;
    const LEGUMBRES = 14;
    const FACIL = 15;
    const CHINA = 16;
    const ESPAÑOLA = 17;
    const INDIA = 18;
    const JAPONESA = 19;
    const ITALIANA = 20;
    const MEXICANA = 21;
    const SUPERPILOPI = 22;
    const PICNIC = 23;
    const PESCAO = 24;
    const FAVORITAS_MARTA = 25;
    const FAVORITAS_RUBEN = 26;
    const PENDIENTES = 27;
    const ADELI = 28;
    const MATRIARCA = 29;
    const JUANAN = 30;

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'category_recipes');
    }

}
