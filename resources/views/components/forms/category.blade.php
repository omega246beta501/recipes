@php
use Illuminate\Database\Eloquent\Collection;
use App\Data\Routes\RecipeRoutes;
use App\Data\Routes\CategoryRoutes;

if(!isset($attachedRecipes)) {
$attachedRecipes = new Collection();
}

$formMode = "insert";
if(isset($category)) {
$formMode = "update";
}

@endphp
<div class="categoryForm">
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" id="{{ $formMode }}CategoryName" placeholder="Nombre" @if(isset($category)) value="{{ $category->name }}" @endif>
        </div>
        <div class="col">
            <select class="form-control" id="{{ $formMode }}RecipesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                @foreach($recipes as $recipe)
                <option value={{ $recipe->id }} @selected($attachedRecipes->contains($recipe))>{{ $recipe->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-10"></div>
        <div class="col">
            @if(isset($category))
            <button class="btn btn-success" onclick="updateCategory({{ $category->id }})">Modificar</button>
            @else
            <button class="btn btn-success" onclick="createCategory()">Crear</button>
            @endif
        </div>
    </div>
</div>
<script>
    function createCategory() {
        var recipesToAttach = [];
        var categoryName = $('#insertCategoryName').val();

        $('#insertRecipesSelect').find(':selected').each(function() {
            recipesToAttach.push(this.value);
        });

        var data = {
            "recipesToAttach": recipesToAttach,
            "newName": categoryName
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('newCategory') }}",
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

    function updateCategory(id) {
        var recipesToAttach = [];
        var categoryName = $('#updateCategoryName').val();

        $('#updateRecipesSelect').find(':selected').each(function() {
            recipesToAttach.push(this.value);
        });

        var data = {
            "id": id,
            "recipesToAttach": recipesToAttach,
            "newName": categoryName
        }

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "{{ route('updateCategory') }}",
            "method": "POST",
            "headers": {
                "cache-control": "no-cache",
                "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
            },
            "data": JSON.stringify(data)
        }

        $.ajax(settings).done(function(response) {
            alert('Se ha actualizado la categoría en el sistema');
            location.reload();
        });
    }
</script>