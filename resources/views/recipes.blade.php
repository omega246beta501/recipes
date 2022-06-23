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
                        <x-forms.recipe :categories="$categories"></x-forms.recipe>
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
            <x-forms.recipe :categories="$categories"></x-forms.recipe>
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