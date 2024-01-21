<script setup>
import { Head } from '@inertiajs/vue3';
import NavFooter from '@/Components/NavFooter.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
    recipes: Array
})

</script>

<template>
    <Head title="Recipes" />

    <div class="row">
        <div class="col-12 header">
            <h2>Recetas</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 card last-card">
            <div class="row card-element" v-for="(recipe, index) in recipes" :key="index">
                <div class="col-xs-2" style="text-align: center;">
                    <div class="no-image">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path d="m16.736 9.252-3.982-5.876A.907.907 0 0 0 12 3a.892.892 0 0 0-.755.385L7.264 9.252H2.909c-.5 0-.909.403-.909.896 0 .08.01.16.036.241l2.31 8.303C4.554 19.445 5.254 20 6.09 20h11.818c.837 0 1.537-.555 1.755-1.308l2.309-8.303.027-.241a.905.905 0 0 0-.91-.896h-4.354Zm-7.463 0L12 5.31l2.727 3.94H9.273ZM12 16.417c-1 0-1.818-.806-1.818-1.791 0-.985.818-1.791 1.818-1.791s1.818.806 1.818 1.79c0 .986-.818 1.792-1.818 1.792Z"></path>
                        </svg>
                    </div>
                    <!-- <img class="image" src="http://192.168.0.177/storage/img_chania.jpg"> -->
                </div>
                <div class="col-xs-7" style="padding-left: 5px;">
                    <a :href="route('borrar2', recipe.id)">{{ recipe.name }}</a>
                </div>
                <div class="col-xs-3">
                    <span>{{ recipe.last_used_at }}</span>
                </div>
            </div>
        </div>
    </div>

    <NavFooter></NavFooter>
</template>
