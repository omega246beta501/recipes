<!-- Formulario de recetas -->
@php
use Illuminate\Database\Eloquent\Collection;
use App\Data\Routes\RecipeRoutes;

if(!isset($attachedCategories)) {
    $attachedCategories = new Collection();
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
        <div class="col-12">
            <textarea class="form-control" id="{{ $formMode }}RecipeDescription" cols="30" rows="10" placeholder="Descripción de la receta (Opcional)">@if(isset($recipe)) {{$recipe->description}} @endif</textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-10"></div>
        <div class="col">
            @if(isset($recipe))
            <button class="btn btn-success" onclick="updateRecipe({{ $recipe->id }})">Actualizar</button>
            @else
            <button class="btn btn-success" onclick="createRecipe()">Crear</button>
            @endif
        </div>
    </div>
</div>

<script>
    function createRecipe() {
        var categoriesToAttach = [];
        var recipeName = $('#insertRecipeName').val();
        var recipePrice = $('#insertRecipePrice').val();
        var recipeKcal = $('#insertRecipeKcal').val();
        var recipeDescription = $('#insertRecipeDescription').val();

        $('#insertSelec2Categories').find(':selected').each(function() {
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

    function updateRecipe(id) {
        var categoriesToAttach = [];
        var recipeName = $('#updateRecipeName').val();
        var recipePrice = $('#updateRecipePrice').val();
        var recipeKcal = $('#updateRecipeKcal').val();
        var recipeDescription = $('#updateRecipeDescription').val();

        $('#updateSelec2Categories').find(':selected').each(function() {
            categoriesToAttach.push(this.value);
        });

        var data = {
            "categoriesToAttach": categoriesToAttach,
            "newName": recipeName,
            "newPrice": recipePrice,
            "newKcal": recipeKcal,
            "newDescription": recipeDescription,
            "id": id
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ RecipeRoutes::UPDATE }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        $.ajax(settings).done(function(response) {
            alert('Se ha actualizado la receta en el sistema');
            location.reload();
        });
    }
</script>