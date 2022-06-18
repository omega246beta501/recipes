<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resetukis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-selection__choice {
            background-color: #fd1dc2;
        }
    </style>
</head>

<body>
    <div class="container">
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
                                    <th>Receta</th>
                                    @if($isMenuSet)
                                    <th>En el menú</th>
                                    @else
                                    <th>Mantener?</th>
                                    @endif
                                </tr>
                            </thead>
                            @foreach($recipes as $recipe)
                            <tr>
                                <th>{{ $recipe->id }}</th>
                                <th>{{ $recipe->name }}</th>
                                @if($isMenuSet)
                                <th><input class="form-check-input keeped" type="checkbox" value="" id="{{ $recipe->id }}" checked disabled></th>
                                @else
                                <th><input class="form-check-input keeped" type="checkbox" value="" id="{{ $recipe->id }}" @checked(isset($keepedRecipesIds) && in_array($recipe->id, $keepedRecipesIds))></th>
                                @endif
                            </tr>
                            @endforeach
                        </table>
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
                    <div class="col"></div>
                    <div class="col">
                        <button type="submit" class="btn btn-warning" onclick="clearMenu()">Reiniciar menú</button>
                    </div>
                    <div class="col"></div>
                </div>
                @endif
            </div>
            <div class="col">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
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
                "url": "http://127.0.0.1:80/recipes/regenerate",
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
                "url": "http://127.0.0.1:80/recipes/include",
                "method": "POST",
                "headers": {
                    "cache-control": "no-cache",
                    "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                },
                "data": JSON.stringify(data)
            }

            $.ajax(settings).done(function(response) {
                alert('Se ha generado el menu para la semana');
                $(".regenerable").html(response);
            });
        }

        function clearMenu() {

            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "http://127.0.0.1:80/recipes/clearMenu",
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
    </script>
</body>

</html>