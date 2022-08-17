<div class="card-grid" id="{{ $gridId }}">
    <div class="row row-cols-3 row-cols-md-4 g-md-4 g-1 text-center">
        @foreach($recipe->ingredients()->orderBy('name')->get() as $ingredient)
        <div class="col d-block" onclick="{{ $cellOnClickCallback }}">
            <div class="ingredient-card d-block">
                <div class="ingredient-card-image">
                    <img class="ingredient-image" src="{{url('/leche.png')}}">
                </div>
                <div class="ingredient-card-text-{{ $recipe->id }} d-block mt-1">
                    <div class="ingredient-card-name d-block">
                        <div class="ingredient-name-div text-break ingredientName-{{ $recipe->id }}" style="font-size: 75%; line-height:10px">{{ $ingredient->name }}</div>
                    </div>
                    <div class="ingredient-card-qty d-none ingredientDQty-{{ $recipe->id }}">{{ $ingredient->pivot->qty }}</div>
                    <div class="ingredient-card-description d-none ingredientDescription-{{ $recipe->id }}">{{ $ingredient->pivot->description }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>