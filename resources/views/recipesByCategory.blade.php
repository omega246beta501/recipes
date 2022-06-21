<!doctype html>
<html lang="en">
@php
    $recipeCounter = 1;
    use App\Data\Routes\MenuRoutes;
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                                    <th>{{ $category->name }}</th>
                                    <th>Última vez</th>
                                </tr>
                            </thead>
                            @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipeCounter }}</td>
                                <td><a href="{{ str_replace('{id}', $recipe->id, MenuRoutes::RECIPE) }}">{{ $recipe->name }}</a></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {});
    </script>
</body>

</html>