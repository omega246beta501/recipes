<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach($attachedIngredients as $ingredient)
    <div class="col">
        <div class="card">
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
        <div class="card">
            <div class="card-header text-center">
                <input id="autocomplete" class="form-control mb-2 text-center" type="text" placeholder="Ingrediente" autocomplete="off">
            </div>
            <div class="card-body">
                <input id="newIngredientQty" class="form-control mb-2 text-center" type="text" placeholder="Cantidad">
                <input id="newIngredientDescription" class="form-control mb-2 text-center" type="text" placeholder="Descripción...">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <button class="btn btn-primary" onclick="addNewIngredient({{  $recipe->id }})">Añadir</button>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
</div>