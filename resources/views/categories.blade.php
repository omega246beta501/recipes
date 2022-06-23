@php
$categoryCounter = 1;
use App\Data\Routes\CategoryRoutes;
@endphp
<x-layout>
    <x-slot:title>Categorías</x-slot>
        <div class="container">
            <div class="row" style="margin-bottom: 1%;">
                <div class="col"></div>
                <div class="col-6">
                    <x-elements.accordion>
                        <x-slot:buttonName>
                            Insertar nueva categoría
                        </x-slot:buttonName>

                        <div class="row">
                            <div class="col">
                                <input type="text" id="categoryName" placeholder="Nombre">
                            </div>
                            <div class="col">
                                <select id="recipesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                                    @foreach($recipes as $recipe)
                                    <option value={{ $recipe->id }}>{{ $recipe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-10"></div>
                            <div class="col">
                                <button class="btn btn-success" onclick="createCategory()">Crear</button>
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
                        <div class="regenerable col">
                            <table class="table table-hover table-dark" id="recipestable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Categoría</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $categoryCounter }}</td>
                                    <td><a href="{{ str_replace('{id}', $category->id, App\Data\Routes\CategoryRoutes::RECIPES_BY_CATEGORY) }}">{{ $category->name }}</a></td>
                                    <td>{{ $category->recipes_count }}</td>
                                </tr>
                                @php $categoryCounter++; @endphp
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
                $('#recipesSelect').select2({
                    width: 'resolve',
                    placeholder: "Recetas a incluir"
                });
            });

            function createCategory() {
                var recipesToAttach = [];
                var categoryName = $('#categoryName').val();

                $('#recipesSelect').find(':selected').each(function() {
                    recipesToAttach.push(this.value);
                });

                var data = {
                    "recipesToAttach": recipesToAttach,
                    "newName": categoryName
                }

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ CategoryRoutes::NEW_CATEGORY }}",
                    "method": "POST",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    },
                    "data": JSON.stringify(data)
                }

                $.ajax(settings).done(function(response) {
                    alert('Se ha incluido una categoría nueva al sistema');
                    location.reload();
                });
            }
        </script>
</x-layout>