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
                                <input class="form-control" type="text" id="recipeName" placeholder="Nombre">
                            </div>
                            <div class="col">
                                <select class="form-control" id="categoriesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                                    @foreach($categories as $category)
                                    <option value={{ $category->id }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="text" id="recipePrice" placeholder="Precio (Opcional)">
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" id="recipeKcal" placeholder="Calorías (Opcional)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <textarea class="form-control" id="recipeDescription" cols="30" rows="10" placeholder="Descripción de la receta (Opcional)"></textarea>
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
                                    <td><a href="#" onclick="openModal({{ $recipe->id }})">{{ $recipe->name }}</a></td>
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
        @foreach($recipes as $recipe)
        <x-elements.modal>
            <x-slot:modalId>{{ $recipe->id }}</x-slot:modalId>
            <x-slot:title>Receta {{ $recipe->name}}</x-slot:title>
            El cuerpesito del modal va aquí
        </x-elements.modal>
        @endforeach
        <script>
            $(document).ready(function() {
                $('#categoriesSelect').select2({
                    width: 'resolve',
                    placeholder: "Categorías a incluir (Opcional)"
                });
            });

            function createRecipe() {
                var categoriesToAttach = [];
                var recipeName = $('#recipeName').val();
                var recipePrice = $('#recipePrice').val();
                var recipeKcal = $('#recipeKcal').val();
                var recipeDescription = $('#recipeDescription').val();

                $('#categoriesSelect').find(':selected').each(function() {
                    categoriesToAttach.push(this.value);
                });

                var data = {
                    "categoriesToAttach": categoriesToAttach,
                    "newName": recipeName,
                    "newPrice": recipePrice,
                    "newKcal": recipeKcal,
                    "newDescription": recipeDescription
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

            function openModal(modalId) {
                $('#' + modalId).modal('show');
            }
        </script>
</x-layout>