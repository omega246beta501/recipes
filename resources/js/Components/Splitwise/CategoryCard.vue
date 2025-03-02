<script>
import { Head } from '@inertiajs/vue3';

export default {
    components: { Head },
    data() {
        return {
        }
    },
    computed: {
    },
    props: {
        categories: Array,
        selectedCategory: Object,
    },
    mounted() {
    },
    beforeDestroy() {
    },
    methods: {
        handleClick(subcategory) {
            this.$emit('change-category', subcategory)
        },
        closeCard() {
            this.$emit('close-card')
        }
    }
}
</script>
<style scoped></style>

<template>
    <div>
        <header>
            Choose a category
            <a @click="closeCard()" class="dismiss" href="#">×</a>
        </header>
        <div class="body">
            <ul>
                <li v-for="category in categories" :key="category.id">
                    {{ category.name }}
                    <i class="icon-chevron-right"></i>
                    <ul>
                        <li @click="handleClick(subcategory); closeCard()" v-for="subcategory in category.subcategories" :key="subcategory.id">
                            {{ subcategory.name }}
                        </li>
                    </ul>
                </li>
            </ul>
            
        </div>
    </div>
</template>
