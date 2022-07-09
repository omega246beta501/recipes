@php
$categoryCounter = 1;
use App\Data\Routes\CategoryRoutes;
@endphp
<x-layout>
    <x-slot:title>Categorías</x-slot>
        <div class="container">
            <div class="row" style="margin-bottom: 1%;">
                <div class="col"></div>
                <div class="col-6">
                    <x-elements.accordion>
                        <x-slot:buttonName>
                            Insertar nueva categoría
                        </x-slot:buttonName>
                        <x-slot:accordionButtonId>
                            newCategoryAccordionButton
                        </x-slot:accordionButtonId>
                        <x-slot:accordionId>
                            newCategoryAccordion
                        </x-slot:accordionId>
                        <x-forms.category :recipes="$recipes"></x-forms.category>
                    </x-elements.accordion>
                </div>
                <div class="col"></div>
            </div>
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
                                    <td><a onclick="openModal('updateModal', {{ $category->id }})">{{ $category->name }}</a></td>
                                    <!-- <td><a href="{{ str_replace('{id}', $category->id, App\Data\Routes\CategoryRoutes::RECIPES_BY_CATEGORY) }}">{{ $category->name }}</a></td> -->
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
        <div class="modalContainer">
            <x-elements.modal>
                <x-slot:modalId>updateModal</x-slot:modalId>
                <x-slot:title>Actualizar Categoría</x-slot:title>
                <!-- Al hacer una peticion al controller, este renderizara el form -->
                <div id="updateCategoryForm"></div>
            </x-elements.modal>
        </div>
        <script>
            $(document).ready(function() {
                $('#insertRecipesSelect').select2({
                    width: 'resolve',
                    placeholder: "Recetas a incluir"
                });
            });

            function openModal(modalId, recipeId) {

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{{ CategoryRoutes::UPDATE_VIEW }}".replace("{id}", recipeId),
                    "method": "GET",
                    "headers": {
                        "cache-control": "no-cache",
                        "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                    }
                }

                $.ajax(settings).done(function(response) {
                    $("#updateCategoryForm").html(response);
                    // Select2 situado en el formulario que general el controller. Metodo UpdateView
                    $('#updateRecipesSelect').select2({
                        width: 'resolve',
                        placeholder: "Categorías a incluir (Opcional)",
                        dropdownParent: $('#' + modalId)
                    });
                });

                $('#' + modalId).modal('show');
            }
        </script>
</x-layout>