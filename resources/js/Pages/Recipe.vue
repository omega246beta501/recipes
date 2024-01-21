<script>
import IngredientList from '@/Components/ViewRecipe/IngredientList.vue';
import Instructions from '@/Components/ViewRecipe/Instructions.vue';
import { Head } from '@inertiajs/vue3';

export default {
    components : { IngredientList, Instructions, Head },
    data() {
        return {
            currentTab: 'IngredientList',
        }
    },
    computed: {
        ingredientListActive() {
            return this.currentTab == 'IngredientList'
        },
        transitionName() {
            return this.currentTab == 'IngredientList' ? "slide-left" : "slide-right"
        }
    },
    props: {
        recipe: Object
    }
}
</script>
<style>
    .recipe-card-element {
        /* margin: 15px; */
        padding: 0px 15px 0px 15px;
        overflow-wrap: anywhere;
        display: flex;
        align-items: center;
        min-height: 58px;
    }

    .recipe-header {
        justify-content: center;
        flex-direction: column;
        display: flex;
        font-size: 22px;
        font-weight: 500;
    }

    .recipe-header-items {
        align-items: center;
        display: inherit;
    }

    .special-button {
        fill: #233748;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        line-height: 0;
        background: transparent;
        border: none;
        padding: 0;
    }

    .recipe-nav {
        display: flex;
        justify-content: space-evenly;
    }

    .nav-active-element {
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 100%;
        color: #ff9939;
    }

    .slide-left-enter-active,
    .slide-right-enter-active,
    .slide-left-leave-active,
    .slide-right-leave-active {
    transition: transform 0.1s;
    }

    .slide-left-enter-from,
    .slide-left-leave-to{
    transform: translateX(100%);
    }

    .slide-right-enter-from,
    .slide-right-leave-to {
    transform: translateX(-100%);
    }

    .slide-left-enter-to,
    .slide-right-enter-to,
    .slide-left-leave-from,
    .slide-right-leave-from {
    transform: translateX(0);
    }
</style>

<template>
    <Head title="Recipe" />

    <div class="sticky-header">
        <div class="row" style="margin-bottom: 25px;">
            <div class="col-12">
                <div class="row recipe-header">
                    <div class="recipe-header-items">
                        <a :href="route('newRecipes')" class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M20 12a1 1 0 0 0-1-1H7.83l4.88-4.88a1 1 0 0 0-1.415-1.415l-6.588 6.588a1 1 0 0 0 0 1.414l6.588 6.588a.997.997 0 0 0 1.41-1.41L7.83 13H19a1 1 0 0 0 1-1Z"></path>
                                </svg>
                            </button>
                        </a>
                        <div class="col-xs-10" style="margin-left: 15px;">{{ recipe.name }}</div>
                        <div class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M7.99 12c0-1.105-.893-2-1.995-2A1.997 1.997 0 0 0 4 12c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM13.975 12c0-1.105-.893-2-1.995-2a1.997 1.997 0 0 0-1.995 2c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM17.965 10c1.102 0 1.995.895 1.995 2s-.893 2-1.995 2a1.997 1.997 0 0 1-1.995-2c0-1.105.893-2 1.995-2Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 recipe-nav">
                <a :class="{ 'nav-active-element': ingredientListActive }" @click="currentTab='IngredientList'">Ingredientes</a>
                <a :class="{ 'nav-active-element': !ingredientListActive }" @click="currentTab='Instructions'">Instrucciones</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 card last-card">
        <Transition :name="transitionName" mode="in-out">
            <component :is="currentTab" :recipe="recipe"></component>
        </Transition>

        </div>
    </div>
</template>
