@php
$recipeCounter = 1;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Recetas</x-slot>
    <div class="container">
        <div class="row">
            <x-elements.accordion>
                <x-slot:buttonName>
                    Insertar nueva receta
                </x-slot:buttonName>
                Aquí va el formulario
            </x-elements.accordion>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ $tableTitle }}</th>
                                    <th>Última vez</th>
                                </tr>
                            </thead>
                            @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipeCounter }}</td>
                                <td><a href="{{ str_replace('{id}', $recipe->id, RecipeRoutes::RECIPE) }}">{{ $recipe->name }}</a></td>
                                <td>{{ $recipe->last_used_at }}</td>
                            </tr>
                            @php $recipeCounter++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
            </div>
        </div>
    </div>
</x-layout>