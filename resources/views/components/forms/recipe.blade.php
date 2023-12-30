<!-- Formulario de recetas -->
@php
use Illuminate\Database\Eloquent\Collection;
use App\Data\Routes\RecipeRoutes;
use App\Data\Routes\IngredientRoutes;

if(!isset($attachedCategories)) {
$attachedCategories = new Collection();
}

if(!isset($attachedIngredients)) {
$attachedIngredients = new Collection();
}

$formMode = "insert";
if(isset($recipe)) {
$formMode = "update";
}

@endphp
<div class="recipeForm">
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" id="{{ $formMode }}RecipeName" placeholder="Nombre" @if(isset($recipe)) value="{{ $recipe->name }}" @endif>
        </div>
        <div class="col">
            <select class="form-control" id="{{ $formMode }}Selec2Categories" name="kk[]" multiple="multiple" style="width: 100%;">
                @foreach($categories as $category)
                <option value={{ $category->id }} @selected($attachedCategories->contains($category))>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" id="{{ $formMode }}RecipePrice" placeholder="Precio (Opcional)" @if(isset($recipe)) value="{{ $recipe->price }}" @endif>
        </div>
        <div class="col">
            <input class="form-control" type="text" id="{{ $formMode }}RecipeKcal" placeholder="Calorías (Opcional)" @if(isset($recipe)) value="{{ $recipe->kcal }}" @endif>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <input class="form-control" type="text" id="{{ $formMode }}RecipeServings" placeholder="Raciones" @if(isset($recipe)) value="{{ $recipe->servings }}" @endif>
        </div>
    </div>
    @if($formMode == 'update')
    <div class="row">
        <div class="col-12">
            <x-elements.accordion>
                <x-slot:buttonName>
                    Ingredientes
                </x-slot:buttonName>
                <x-slot:accordionButtonId>
                    @if($formMode == 'insert')
                    newIngredientsAccordionButton
                    @else
                    updateIngredientsAccordionButton
                    @endif
                </x-slot:accordionButtonId>
                <x-slot:accordionId>
                    @if($formMode == 'insert')
                    newIngredientsAccordion
                    @else
                    updateIngredientsAccordion
                    @endif
                </x-slot:accordionId>
                <div id="ingredientsGrid" class="card-grid" xyz>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach($attachedIngredients as $ingredient)
                        <div class="col">
                            <div class="card xyz-in">
                                <div class="card-header text-center bg-danger bg-gradient bg-opacity-75" onclick="detachRecipeFromIngredient(event, {{ $recipe->id }}, {{ $ingredient->id }})">
                                    {{ $ingredient->name }}
                                </div>
                                <div class="card-body">
                                    <input id="{{$recipe->id}}-{{$ingredient->id}}-qty" class="form-control mb-2 text-center" type="text" placeholder="Cantidad" value="{{ $ingredient->pivot->qty }}">
                                    <input id="{{$recipe->id}}-{{$ingredient->id}}-description" class="form-control mb-2 text-center" type="text" placeholder="Descripción..." value="{{ $ingredient->pivot->description }}">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col">
                                            <button class="btn btn-success" onclick="updateAttachedIngredient({{$recipe->id}}, {{$ingredient->id}})">Actualizar</button>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col">
                            <div class="card xyz-in" xyz="fade right-100% delay-6">
                                <div class="card-header text-center">
                                    <input id="autocomplete" class="form-control mb-2 text-center" type="text" placeholder="Ingrediente" autocomplete="off">
                                </div>
                                <div class="card-body">
                                    <input id="newIngredientQty" class="form-control mb-2 text-center" type="text" placeholder="Cantidad">
                                    <input id="newIngredientDescription" class="form-control mb-2 text-center" type="text" placeholder="Descripción...">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col">
                                            <button class="btn btn-primary" onclick="addNewIngredient({{ $recipe->id }})">Añadir</button>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-elements.accordion>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <textarea class="form-control" id="{{ $formMode }}RecipeDescription" cols="30" rows="10" placeholder="Descripción de la receta (Opcional)">@if(isset($recipe)){{$recipe->description}}@endif</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input class="form-control" id="{{ $formMode }}RecipeUrl" placeholder="Url vídeo de la receta (Opcional)" @if(isset($recipe)) value="{{$recipe->url}}" @endif>
        </div>
    </div>
    @if(isset($recipe) && isset($recipe->url) && $recipe->url != '')
    <div class="row">
        <div class="col">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" width="100%" height="400" src="{{ $recipe->url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    @endif
    <div class="row" style="margin-top: 2%;">
        <div class="col">
            @if(isset($recipe))
            <button class="btn btn-success" onclick="updateRecipe({{ $recipe->id }})">Actualizar</button>
            @else
            <button class="btn btn-success" onclick="createRecipe()">Crear</button>
            @endif
        </div>
    </div>
</div>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    function createRecipe() {
        var categoriesToAttach = [];
        var recipeName = $('#insertRecipeName').val();
        var recipePrice = $('#insertRecipePrice').val();
        var recipeKcal = $('#insertRecipeKcal').val();
        var recipeDescription = $('#insertRecipeDescription').val();
        var recipeUrl = $('#insertRecipeUrl').val();
        var recipeServings = $('#insertRecipeServings').val();

        $('#insertSelec2Categories').find(':selected').each(function() {
            categoriesToAttach.push(this.value);
        });

        var data = {
            "categoriesToAttach": categoriesToAttach,
            "newName": recipeName,
            "newPrice": recipePrice,
            "newKcal": recipeKcal,
            "newDescription": recipeDescription,
            "newUrl": recipeUrl,
            "newServings": recipeServings
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('newRecipe') }}",
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

    function updateRecipe(id) {
        var categoriesToAttach = [];
        var recipeName = $('#updateRecipeName').val();
        var recipePrice = $('#updateRecipePrice').val();
        var recipeKcal = $('#updateRecipeKcal').val();
        var recipeDescription = $('#updateRecipeDescription').val();
        var recipeUrl = $('#updateRecipeUrl').val();
        var recipeServings = $('#updateRecipeServings').val();

        $('#updateSelec2Categories').find(':selected').each(function() {
            categoriesToAttach.push(this.value);
        });

        var data = {
            "categoriesToAttach": categoriesToAttach,
            "newName": recipeName,
            "newPrice": recipePrice,
            "newKcal": recipeKcal,
            "newDescription": recipeDescription,
            "newUrl": recipeUrl,
            "newServings": recipeServings,
            "id": id
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('updateRecipe') }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        $.ajax(settings).done(function(response) {
            alert('Se ha actualizado la receta en el sistema');
        });
    }

    function addNewIngredient(recipeId) {

        var newIngredientName = $('#autocomplete').val();
        var newIngredientQty = $('#newIngredientQty').val();
        var newIngredientDescription = $('#newIngredientDescription').val();

        if(newIngredientQty != "") {
            newIngredientQty = parseFloat(newIngredientQty);
    
            if(isNaN(newIngredientQty)) {
                alert('La cantidad de un ingrediente debe ser un número');
                return;
            }
        }

        var data = {
            "recipeId": recipeId,
            "newIngredientName": newIngredientName,
            "newIngredientQty": newIngredientQty,
            "newIngredientDescription": newIngredientDescription,
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('attachRecipe') }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        $.ajax(settings).done(function(response) {
            $("#ingredientsGrid").html(response);

            $("#autocomplete").autocomplete({
                source: "{{ route('queryIngredients') }}"
            });
        });
    }

    function detachRecipeFromIngredient(event, recipeId, ingredientId) {

        var data = {
            "recipeId": recipeId,
            "ingredientId": ingredientId,
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('detachRecipe') }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        detach = true;

        if (event.ctrlKey == false) {
            detach = confirm("¿Deseas eliminar el ingrediente de la receta?");
        }

        if (detach) {
            $.ajax(settings).done(function(response) {
                var card = $(event.target).parent();
                var col = $(card).parent();

                $(card).addClass('xyz-out');

                setTimeout(function() {
                    $(col).remove();
                }, 300);

                $("#autocomplete").autocomplete({
                    source: "{{ route('queryIngredients') }}"
                });
            });
        }
    }

    function updateAttachedIngredient(recipeId, ingredientId) {

        description = $("#" + recipeId + "-" + ingredientId + "-description").val();
        qty = $("#" + recipeId + "-" + ingredientId + "-qty").val();

        if(qty != "") {
            qty = parseFloat(qty);
    
            if(isNaN(qty)) {
                alert('La cantidad de un ingrediente debe ser un número');
                return;
            }
        }
        var data = {
            "recipeId": recipeId,
            "ingredientId": ingredientId,
            "qty": qty,
            "description": description
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('updateAttachedRecipe') }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        $.ajax(settings).done(function(response) {
            $("#ingredientsGrid").html(response);

            $("#autocomplete").autocomplete({
                source: "{{ route('queryIngredients') }}"
            });
            alert('Se ha actualizado el ingrediente en el sistema');
        });
    }

    $(document).ready(function() {
        $("#autocomplete").autocomplete({
            source: "{{ route('queryIngredients') }}"
        });
    });
</script>