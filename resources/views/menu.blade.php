@php
use App\Data\Routes\MenuRoutes;
@endphp
<x-layout>
    <x-slot:title>Menú</x-slot>
        <div class="container">
            <div class="row">
                <div class="col">
                </div>
                <div class="col">
                    <div class="row">
                        <div class="regenerable col">
                            <x-menu.table :is-menu-set="$isMenuSet" :recipes="$recipes">
                            </x-menu.table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select id="includedCategoriesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                                @foreach($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select id="excludedCategoriesSelect" name="states[]" multiple="multiple" style="width: 100%;">
                                    @foreach($categories as $category)
                                    <option value={{ $category->id }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" @disabled($isMenuSet) class="btn btn-danger" onclick="regenerate()">Regenerar recetas</button>
                        </div>
                        <div class="col">
                            <button type="submit" @disabled($isMenuSet) class="btn btn-primary" onclick="includeInMenu()">Asignar menú</button>
                        </div>
                    </div>
                    @if($isMenuSet)
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-warning" onclick="newMenu()">Nuevo Menú</button>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-warning" onclick="clearMenu()">Reiniciar menú</button>
                        </div>
                    </div>

                    @endif
                </div>
                <div class="col">
                </div>
            </div>
            @if($isMenuSet)
            <div class="row mt-5">
                <div class="col"></div>
                <div class="col-6">
                    <table class="table table-hover table-dark" id="shoppingListTable">
                        <thead>
                            <tr>
                                <th>Elemento</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        @foreach($shoppingList as $element)
                        <tr>
                            <th>{{ $element->name }}</th>
                            <th>{{ $element->pivot->description }}</th>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col"></div>
            </div>
            @endif
        </div>
        <script>
            $(document).ready(function() {
                $('#includedCategoriesSelect').select2({
                    width: 'resolve',
                    placeholder: "Categorías a incluir"
                });
                $('#excludedCategoriesSelect').select2({
                    width: 'resolve',
                    placeholder: "Categorías a excluir"
                });
            });

            function regenerate() {
                var selectedToKeepIds = [];
                var includedCategories = [];
                var excludedCategories = [];

                $('#recipestable input:checked').each(function() {
                    selectedToKeepIds.push($(this).attr('id'));
                });

                $('#includedCategoriesSelect').find(':selected').each(function() {
                    includedCategories.push(this.value);
                });

                $('#excludedCategoriesSelect').find(':selected').each(function() {
                    excludedCategories.push(this.value);
                });

                var data = {
                    "keepedRecipesIds": selectedToKeepIds,
                    "includedCategoriesIds": includedCategories,
                    "excludedCategoriesIds": excludedCategories
                }

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ MenuRoutes::REGENERATE_RECIPES }}",
                    "method": "POST",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    },
                    "data": JSON.stringify(data)
                }

                $.ajax(settings).done(function(response) {
                    $(".regenerable").html(response);
                });
            }

            function includeInMenu() {

                var selectedToInsert = [];

                $('#recipestable input:checkbox').each(function() {
                    selectedToInsert.push($(this).attr('id'));
                });

                var data = {
                    "recipesToInclude": selectedToInsert
                }

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ MenuRoutes::CREATE_MENU }}",
                    "method": "POST",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    },
                    "data": JSON.stringify(data)
                }

                $.ajax(settings).done(function(response) {
                    alert('Se ha generado el menu para la semana');
                    location.reload();
                });
            }

            function clearMenu() {

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ MenuRoutes::DISCARD_MENU }}",
                    "method": "GET",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    }
                }
                response = confirm("¿Estás seguro de querer borrar el menú?");

                if (response) {
                    $.ajax(settings).done(function(response) {
                        alert('Se ha borrado el menú de la semana. Las recetas no utilizadas vuelven a estar disponibles.');
                        location.reload();
                    });
                }
            }

            function newMenu() {

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ MenuRoutes::NEW_MENU }}",
                    "method": "GET",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    }
                }
                response = confirm("¿Estás seguro de querer archivar el menú actual?");

                if (response) {
                    $.ajax(settings).done(function(response) {
                        alert('El antiguo menu ha sido archivado. Ahora puedes crear un nuevo menú');
                        location.reload();
                    });
                }
            }
        </script>
</x-layout>