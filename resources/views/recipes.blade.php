@php
$recipeCounter = 1;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Recetas</x-slot>
        <div class="container">
            <div class="row" style="margin-bottom: 1%;">
                <div class="col"></div>
                <div class="col-6">
                    <x-elements.accordion>
                        <x-slot:buttonName>
                            Insertar nueva receta
                        </x-slot:buttonName>
                        <div class="row">
                            <div class="col">
                                <input type="text" id="recipeName" placeholder="Nombre">
                            </div>
                            <div class="col">
                                <select id="categoriesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                                    @foreach($categories as $category)
                                    <option value={{ $category->id }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-10"></div>
                            <div class="col">
                                <button class="btn btn-success" onclick="createRecipe()">Crear</button>
                            </div>
                        </div>
                    </x-elements.accordion>
                </div>
                <div class="col"></div>
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
        <script>
            $(document).ready(function() {
                $('#categoriesSelect').select2({
                    width: 'resolve',
                    placeholder: "Categorías a incluir"
                });
            });

            function createRecipe() {
                var categoriesToAttach = [];
                var recipeName = $('#recipeName').val();

                $('#categoriesSelect').find(':selected').each(function() {
                    categoriesToAttach.push(this.value);
                });

                var data = {
                    "categoriesToAttach": categoriesToAttach,
                    "newName": recipeName
                }

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ RecipeRoutes::NEW_RECIPE }}",
                    "method": "POST",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    },
                    "data": JSON.stringify(data)
                }

                $.ajax(settings).done(function(response) {
                    alert('Se ha incluido una receta nueva al sistema');
                    location.reload();
                });
            }
        </script>
</x-layout>