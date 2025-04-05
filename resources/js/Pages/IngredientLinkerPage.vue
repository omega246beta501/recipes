<script>
import { Head } from '@inertiajs/vue3';
import StickyHeader from '@/Components/General/StickyHeader.vue';
import NavFooter from '@/Components/General/NavFooter.vue';
import IngredientList from '@/Components/General/IngredientList.vue';

export default {
    components: { Head, StickyHeader, NavFooter, IngredientList },
    props: {
        list: Array
    },
    data() {
        return {
            ingredient: null,
            queryInput: '',
            mercadonaIngredients: [],
            selectedIndex: -1,
        }
    },
    computed: {
        selectedIngredient() {
            return this.list[this.selectedIndex]
        }
    },
    mounted() {
    },
    beforeDestroy() {
    },
    methods: {
        ingredientClick(ingredient, index) {
            // this.ingredient = ingredient
            this.selectedIndex = index
            if (ingredient.mercadona_product) {
                this.queryInput = ingredient.mercadona_product.name
                this.mercadonaIngredients = [ingredient.mercadona_product]
            }
            else {
                this.queryInput = ingredient.name
                this.queryMercadonaProduct()
            }
        },
        async queryMercadonaProduct() {
            try {
                const data = {
                    query: this.queryInput,
                };
                const response = await fetch(route('mercadonaQuery'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Check if the response is ok.
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const result = await response.json();
                this.mercadonaIngredients = result.mercadonaIngredients;
            }catch (error) {
                // Handle any errors that occur during the fetch.
                console.error('Error creating expense:', error);
                alert('Ha ocurrido un error al crear el cargo. Por favor, intente nuevamente.');
            }
        },
        async attachMercadonaProduct(mercadonaProduct) {
            try {
                const data = {
                    ingredient_id: this.selectedIngredient.id,
                    mercadonaProduct: mercadonaProduct
                };
                const response = await fetch(route('attachMercadonaProduct'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Check if the response is ok.
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                alert("Se ha asociado correctamente el product al ingrediente")
                const result = await response.json();
                this.list[this.selectedIndex].mercadona_product = result.mercadonaProduct;
            }catch (error) {
                // Handle any errors that occur during the fetch.
                console.error('Error creating expense:', error);
                alert('Ha ocurrido un error al asociar un producto al ingrediente.');
            }
        }
    }
}
</script>
<style scoped>
.selected {
    background: #f3f3f3;
}
</style>

<template>

    <Head title="IngredientLinkerPage" />

    <StickyHeader name="Ingredient Linker" :backRoute="route('newRecipes')">
    </StickyHeader>

    <div class="row">
        <div class="col-6">
            <IngredientList :ingredients="list" :isFromRecipes="false" @ingredientClick="ingredientClick">
            </IngredientList>
        </div>
        <div class="col-6 card last-card" style="position: sticky; top: 95px">
            <div class="row ingredient-card-element">
                <div class="col">
                    <input type="text" v-model="queryInput" @keyup.enter="queryMercadonaProduct">
                </div>
            </div>
            <div v-for="(ingredient, index) in mercadonaIngredients" :key="index" class="row ingredient-card-element" @click="attachMercadonaProduct(ingredient)">
                <div class="col-xs-2" style="text-align: center;">
                    <img class="image" :src=ingredient.image_path loading="eager">
                </div>
                <div class="col-xs-10" style="padding-left: 5px; padding-top: 15px;">
                    <span>
                        {{ ingredient.name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <NavFooter></NavFooter>
</template>
