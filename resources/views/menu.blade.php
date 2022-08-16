@php
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Menú</x-slot>
        @foreach ($recipes as $recipe)
        <div id="receta{{ $recipe->id }}" class="recipe-canvas container-fluid" xyz="right-100% duration-2.5">
            <div class="canvas-header shadow py-3 align-items-center row position-sticky top-0" style="background-color: #2f3c42;">
                <div class="col-1">
                    <button onclick="closeCanvas(event)" type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                </div>
                <div class="col-3 offset-8 fs-6 fw-bold" style="font-size:0.8rem!important;"><span onclick="saveRecipe({{ $recipe->id }})">GUARDAR</span></div>
            </div>
            <div class="canvas-title row justify-content-center text-center mt-4">
                <div class="col" contenteditable="true">
                    <h1 id="recipeName-{{ $recipe->id }}">{{ $recipe->name }}</h1>
                </div>
            </div>
            <div class="recipe-canvas-description @if(!empty($recipe->description)) shadow @endif pb-1 row mt-4">
                <div class="col" contenteditable="true">
                    @if(!empty($recipe->description))
                    @php
                    $descriptionLines = explode("\n", $recipe->description);
                    @endphp
                    @foreach ($descriptionLines as $descriptionLine)
                    <span class="mt-1 d-block recipeDescription-{{ $recipe->id }}">{{ $descriptionLine }}</span>
                    @endforeach
                    @else
                    <span class="mt-1 d-block recipeDescription-{{ $recipe->id }}">Descripción</span>
                    @endif
                </div>
            </div>
            <div class="canvas-ingredients row mt-4 g-1">
                <div class="col-1">Ingredientes</div>
                <div class="col-2 offset-9">
                    <button onclick="openEditIngredientsCanvas('{{ $recipe->id }}')">Editar</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="card-grid" id="recipe-ingredients-grid-{{ $recipe->id }}">
                    <div class="row row-cols-3 row-cols-md-4 g-md-4 g-1 text-center">
                        @foreach($recipe->ingredients as $ingredient)
                        <div class="col d-block" onclick="deleteIngredient(event)">
                            <div class="ingredient-card d-block">
                                <div class="ingredient-card-image">
                                    <img class="ingredient-image" src="{{url('/leche.png')}}">
                                </div>
                                <div class="ingredient-card-text d-block mt-1">
                                    <div class="ingredient-card-name d-block">
                                        <div class="ingredient-name-div text-break ingredientName-{{ $recipe->id }}" style="font-size: 75%; line-height:10px">{{ $ingredient->name }}</div>
                                    </div>
                                    <div class="ingredient-card-description d-block ingredientDescription-{{ $recipe->id }}"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
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
                olakase
            </div>
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
                    // var quantity = $('#new-quantity-' + recipeId).val();
                    // var unit = $('#new-unit-' + recipeId).val();
                    var description = [];
                    $('.recipeDescription-' + recipeId).each(function() {
                        description.push($(this).html());
                    });

                    description = description.join('\n');

                    var ingredients = [];
                    $('.ingredientName-' + recipeId).each(function() {
                        ingredients.push($(this).html());
                    });

                    var data = {
                        "name": name,
                        "description": description,
                        "ingredients": ingredients
                    }

                    alert(JSON.stringify(data));
                    
                }
            </script>
        </div>
</x-layout>