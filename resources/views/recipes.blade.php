@php
$recipeCounter = 1;
use App\Data\Routes\MenuRoutes;
use App\Data\Routes\RecipeRoutes;
@endphp
<x-layout>
    <x-slot:title>Recetas</x-slot>
        <div class="container">
            <div class="row" style="margin-bottom: 1%;">
                <div class="col"></div>
                <div class="col-6">
                    <x-elements.accordion>
                        <x-slot:buttonName>
                            Insertar nueva receta
                        </x-slot:buttonName>
                        <x-slot:accordionButtonId>
                            newRecipeAccordionButton
                        </x-slot:accordionButtonId>
                        <x-slot:accordionId>
                            newRecipeAccordion
                        </x-slot:accordionId>
                        <x-forms.recipe :categories="$categories"></x-forms.recipe>
                    </x-elements.accordion>
                </div>
                <div class="col"></div>
            </div>
            <div class="row">
                <div class="col">
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <table class="table table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ $tableTitle }}</th>
                                        <th>Última vez</th>
                                    </tr>
                                </thead>
                                @foreach($recipes as $recipe)
                                <tr>
                                    <td>{{ $recipeCounter }}</td>
                                    <td><a onclick="openModal('updateModal', {{ $recipe->id }})">{{ $recipe->name }}</a></td>
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
        <div class="modalContainer">
            <x-elements.modal>
                <x-slot:modalId>updateModal</x-slot:modalId>
                <x-slot:title>Actualizar Receta</x-slot:title>
                <!-- Al hacer una peticion al controller, este renderizara el form -->
                <div id="updateRecipeForm"></div>
            </x-elements.modal>
        </div>
        <script>
            $(document).ready(function() {
                $('#insertSelec2Categories').select2({
                    width: 'resolve',
                    placeholder: "Categorías a incluir (Opcional)"
                });
            });

            function openModal(modalId, recipeId) {

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ RecipeRoutes::UPDATE_VIEW }}".replace("{id}", recipeId),
                    "method": "GET",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    }
                }

                $.ajax(settings).done(function(response) {
                    $("#updateRecipeForm").html(response);
                    // Select2 situado en el formulario que general el controller. Metodo UpdateView
                    $('#updateSelec2Categories').select2({
                        width: 'resolve',
                        placeholder: "Categorías a incluir (Opcional)",
                        dropdownParent: $('#' + modalId)
                    });
                    
                    $('#' + modalId).modal('show');
                });

            }
        </script>
</x-layout>