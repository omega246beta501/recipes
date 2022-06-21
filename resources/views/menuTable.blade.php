@php
    use App\Data\Routes\MenuRoutes;
@endphp
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
        <th><a href="{{ str_replace('{id}', $recipe->id, MenuRoutes::RECIPE) }}">{{ $recipe->name }}</a></th>
        @if($isMenuSet)
        <th><input class="form-check-input keeped" type="checkbox" value="" id="{{ $recipe->id }}" checked disabled></th>
        @else
        <th><input class="form-check-input keeped" type="checkbox" value="" id="{{ $recipe->id }}" @checked(isset($keepedRecipesIds) && in_array($recipe->id, $keepedRecipesIds))></th>
        @endif
    </tr>
    @endforeach
</table>