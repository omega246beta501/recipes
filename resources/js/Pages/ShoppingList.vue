<script>
import { Head } from '@inertiajs/vue3';
import StickyHeader from '@/Components/General/StickyHeader.vue';
import NavFooter from '@/Components/General/NavFooter.vue';
import IngredientList from '@/Components/General/IngredientList.vue';

export default {
    components : { Head, StickyHeader, NavFooter, IngredientList },
    props: {
        list: Array
    },
    data() {
        return {
        }
    },
    computed: {
    },
    mounted() {
    },
    beforeDestroy() {
    },
    methods: {
    }
}
</script>
<style>

</style>

<template>
    <Head title="Shopping List" />

    <StickyHeader name="Shopping List" :backRoute="route('newRecipes')">
    </StickyHeader>

    <div class="row">
        <IngredientList :ingredients="list"></IngredientList>
    </div>
    <NavFooter></NavFooter>
</template>
