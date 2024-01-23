<script>
import IngredientList from '@/Components/General/IngredientList.vue';
import Instructions from '@/Components/ViewRecipe/Instructions.vue';
import { Head } from '@inertiajs/vue3';
import StickyHeader from '@/Components/General/StickyHeader.vue';

export default {
    components : { IngredientList, Instructions, Head, StickyHeader },
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
    },
    mounted() {
        // Add scroll event listener to the window
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy() {
        // Remove the scroll event listener when the component is destroyed
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        handleScroll() {
            // Access scroll-related information
            console.log("Window scrolling");
            
            // You can also access the scroll position if needed
            const scrollPositionX = window.scrollX;
            const scrollPositionY = window.scrollY;
            console.log("Horizontal Scroll position:", scrollPositionX);
            console.log("Vertical Scroll position:", scrollPositionY);
        }
    }
}
</script>
<style>
    
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

    .section {
        width: 100vw; 
        height: 100vh; 
        display: inline-block; 
        box-sizing: border-box;
        vertical-align: top; 
        scroll-snap-align: end;
        white-space: normal;
    }

    .scrolling-sections {
        scroll-snap-type: x mandatory;
        overflow-x: auto;
        white-space: nowrap;
        scroll-behavior: smooth;
    }
</style>

<template>
    <Head title="Recipe" />

    <StickyHeader :name="recipe.name" :backRoute="route('newRecipes')">
        <div class="row">
            <div class="col-12 recipe-nav">
                <a href="#ingredients_section" :class="{ 'nav-active-element': ingredientListActive }" @click="currentTab='IngredientList'">Ingredientes</a>
                <a href="#instructions_section" :class="{ 'nav-active-element': !ingredientListActive }" @click="currentTab='Instructions'">Instrucciones</a>
            </div>
        </div>
    </StickyHeader>

    <div class="row scrolling-sections">
        <div class="section" id="ingredients_section">
            <IngredientList :ingredients="recipe.ingredients"></IngredientList>
        </div>
        <div class="section" id="instructions_section">
            <Instructions :recipe="recipe"></Instructions>
        </div>
    </div>
</template>
