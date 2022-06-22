@php
$recipeCounter = 1;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Recetas</x-slot>
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <div class="row">
                    <div class="regenerable col">
                        <table class="table table-hover table-dark" id="recipestable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ $category->name }}</th>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {});
    </script>
</x-layout>