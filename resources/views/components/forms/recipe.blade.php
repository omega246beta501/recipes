<div class="recipeForm">
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" id="recipeName" placeholder="Nombre">
        </div>
        <div class="col">
            <select class="form-control" id="categoriesSelect" name="kk[]" multiple="multiple" style="width: 100%;">
                @foreach($categories as $category)
                <option value={{ $category->id }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" id="recipePrice" placeholder="Precio (Opcional)">
        </div>
        <div class="col">
            <input class="form-control" type="text" id="recipeKcal" placeholder="Calorías (Opcional)">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <textarea class="form-control" id="recipeDescription" cols="30" rows="10" placeholder="Descripción de la receta (Opcional)"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-10"></div>
        <div class="col">
            <button class="btn btn-success" onclick="createRecipe()">Crear</button>
        </div>
    </div>
</div>