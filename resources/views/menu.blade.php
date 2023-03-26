@php
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Menú</x-slot>
        <card-component>
            <span slot="recipe-name">Ogt</span>
        </card-component>
        @foreach ($recipes as $recipe)
        <div id="receta{{ $recipe->id }}" class="recipe-canvas container-fluid" xyz="right-100% duration-2.5">
            <div class="canvas-header shadow py-3 align-items-center row position-sticky top-0" style="background-color: #2f3c42;">
                <div class="col-1">
                    <button onclick="closeCanvas(event)" type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                </div>
                <div class="col-3 offset-8 fs-6 fw-bold" style="font-size:0.8rem!important;"><span onclick="saveRecipe({{ $recipe->id }})">GUARDAR</span></div>
            </div>
            <div class="canvas-title row justify-content-center text-center mt-4">
                <div class="col recipe-name" contenteditable="true">
                    <h1 id="recipeName-{{ $recipe->id }}">{{ $recipe->name }}</h1>
                </div>
            </div>
            <div class="recipe-canvas-description shadow pb-1 row mt-4">
                <div class="col">
                    <textarea class="recipe-input" id="recipeDescription-{{ $recipe->id }}" cols="2000" oninput="adjustRecipeDescriptionHeight(this)" onload="adjustRecipeDescriptionHeight(this)" placeholder="Descripción">{{$recipe->description}}</textarea>
                </div>
            </div>
            <div class="d-none row mt-4">
                <div class="col">
                    <input value="{{ $recipe->url }}">
                </div>
            </div>
            <div class="canvas-ingredients row mt-4 g-1">
                <div class="col-1">Ingredientes</div>
                <div class="col-2 offset-9">
                    <button onclick="openEditIngredientsCanvas('{{ $recipe->id }}')">Editar</button>
                </div>
            </div>
            <div class="row mt-2">
                <x-elements.grid :recipe="$recipe" :ingredients="$recipe->ingredients()->orderBy('name')->get()">
                    <x-slot:gridId>recipe-ingredients-grid-{{ $recipe->id }}</x-slot:gridId>
                    <x-slot:cellOnClickCallback>deleteIngredient(event)</x-slot:gridId>
                </x-elements.grid>
            </div>
        </div>
        <div id="edit-ingredients-{{ $recipe->id }}" class="edit-ingredients-canvas container-fluid" xyz="right-100% duration-2.5">
            <div class="canvas-header py-3 align-items-center row position-sticky top-0" style="background-color: #2f3c42;">
                <div class="col-1">
                    <button onclick="closeEditIngredientsCanvas(event, {{ $recipe->id }})" type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                </div>
                <div class="col-1"></div>
                <div class="col-8 fs-5 fw-bold">Agregar Ingredientes</div>
                <div class="col-2 fs-6 fw-bold" style="font-size:0.8rem!important;"><span onclick="saveEditIngredients(event, {{ $recipe->id }})">LISTO</span></div>
            </div>
            <div class="canvas-header shadow py-3 align-items-center row position-sticky top-0" style="background-color: #2f3c42;">
                <div class="col">
                    <input id="ingredient-searcher-{{ $recipe->id }}" type="text" placeholder="Busca un ingrediente..." oninput="searchIngredient({{ $recipe->id }})">
                </div>
            </div>
            <div class="row mt-2 d-none" id="regenerable-search-grid-{{ $recipe->id }}"></div>
            <div class="row mt-2">
                <div class="card-grid" id="recipe-ingredients-grid-edit-{{ $recipe->id }}"></div>
            </div>
        </div>
        @endforeach
        <div class="container mt-2" xyz="fade right-100%">
            <div class="row">
                <div class="col d-none d-md-block">
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
                        <div class="col">
                            <select id="excludedCategoriesSelect" name="states[]" multiple="multiple" style="width: 100%;">
                                @foreach($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select id="includedIngredientsSelect" name="ingredients[]" multiple="multiple" style="width: 100%;">
                                @foreach($ingredients as $ingredient)
                                <option value={{ $ingredient->id }}>{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
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
                <div class="col d-none d-md-block">
                </div>
                @if($isMenuSet)
                <div class="row mt-5">
                    <div class="col-sm-6 offset-sm-3">
                        <table class="table table-sm table-hover table-dark" id="shoppingListTable">
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
                    $('#includedIngredientsSelect').select2({
                        width: 'resolve',
                        placeholder: "Recetas que contengan"
                    });
                });

                function regenerate() {
                    var selectedToKeepIds = [];
                    var includedCategories = [];
                    var excludedCategories = [];
                    var includedIngredients = [];

                    $('#recipestable input:checked').each(function() {
                        selectedToKeepIds.push($(this).attr('id'));
                    });

                    $('#includedCategoriesSelect').find(':selected').each(function() {
                        includedCategories.push(this.value);
                    });

                    $('#excludedCategoriesSelect').find(':selected').each(function() {
                        excludedCategories.push(this.value);
                    });

                    $('#includedIngredientsSelect').find(':selected').each(function() {
                        includedIngredients.push(this.value);
                    });

                    var data = {
                        "keepedRecipesIds": selectedToKeepIds,
                        "includedCategoriesIds": includedCategories,
                        "excludedCategoriesIds": excludedCategories,
                        "includedIngredientsIds": includedIngredients
                    }

                    var settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "{{ route('regenerateRecipes', ['tenant' => tenant()]) }}",
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
                        "url": "{{ route('createMenu', ['tenant' => tenant()]) }}",
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
                        "url": "{{ route('discardMenu', ['tenant' => tenant()]) }}",
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
                        "url": "{{ route('newMenu', ['tenant' => tenant()]) }}",
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

                function openEditIngredientsCanvas(recipeId) {
                    $('#recipe-ingredients-grid-edit-' + recipeId).html($('#recipe-ingredients-grid-' + recipeId).html());
                    openCanvas('edit-ingredients-' + recipeId);
                }

                function closeEditIngredientsCanvas(event, recipeId) {
                    $('#recipe-ingredients-grid-edit-' + recipeId).html(null);
                    closeCanvas(event);
                }

                function saveEditIngredients(event, recipeId) {
                    $('#recipe-ingredients-grid-' + recipeId).html($('#recipe-ingredients-grid-edit-' + recipeId).html());
                    $('#recipe-ingredients-grid-edit-' + recipeId).html(null);
                    closeCanvas(event);
                }

                function saveRecipe(recipeId) {
                    var name = $('#recipeName-' + recipeId).html();
                    var description = $('#recipeDescription-' + recipeId).val();

                    var ingredients = [];
                    $('.ingredient-card-text-' + recipeId).each(function() {
                        var ingredientName = $($(this).children()[0]).children().html()
                        var ingredientQty = $($(this).children()[1]).html();
                        var ingredientDescription = $($(this).children()[2]).html();

                        ingredients.push({
                            "name": ingredientName,
                            "qty": ingredientQty,
                            "description": ingredientDescription
                        });
                    });

                    var data = {
                        "name": name,
                        "id": recipeId,
                        "description": description,
                        "ingredients": ingredients,
                    }

                    var settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "{{ route('storeRecipe', ['tenant' => tenant()]) }}",
                        "method": "POST",
                        "headers": {
                            "cache-control": "no-cache",
                        },
                        "data": JSON.stringify(data)
                    }

                    alert(JSON.stringify(data));
                    $.ajax(settings).done(function(response) {
                        alert('Se ha guardado la receta');
                    });
                }

                function adjustRecipeDescriptionHeight(element) {
                    element.style.height = "";
                    element.style.height = element.scrollHeight + "px";
                }

                function searchIngredient(recipeId) {
                    var term = $('#ingredient-searcher-' + recipeId).val();
                    var mainGrid = $('#recipe-ingredients-grid-edit-' + recipeId);
                    var searchGrid = $('#regenerable-search-grid-' + recipeId);

                    mainGrid.addClass('d-none');
                    searchGrid.removeClass('d-none');

                    var data = {
                        "term": term,
                        "gridId": 'recipe-ingredients-grid-search-' + recipeId,
                        "recipeId": recipeId
                    }

                    var settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "{{ route('queryIngredients', ['tenant' => tenant()]) }}",
                        "method": "POST",
                        "headers": {
                            "cache-control": "no-cache",
                        },
                        "data": JSON.stringify(data)
                    }

                    $.ajax(settings).done(function(response) {
                        $('#regenerable-search-grid-' + recipeId).html(response);
                    });
                }
            </script>
        </div>
</x-layout>