
@php
    $categoryCounter = 1;
@endphp
<x-layout>
    <x-slot:title>Categorías</x-slot>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {});
    </script>
</x-layout>