<script>
import Category from './Category.vue'
import Accordion from './Accordion.vue'

export default {

    components: {
        Category,
        Accordion
    },
    data() {
        return {
            selectedCategory: null
        }
    },
    props: {
        categories: {
            type: Array,
            required: true
        },
        recipes: {
            type: Array,
            required: true
        },
        categoriesUrls: {
            type: Object,
            required: true
        }
    },
    methods: {
        selectCategory(category) {
            this.selectedCategory = category
        }
    }
}
</script>

<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col d-none d-md-block"></div>
            <div class="col-md-6 col-sm">
                <!-- Acordeon va aqui -->
                <Accordion title="Insertar nueva categoría">
                    <Category :inCategory="selectedCategory" :recipes="recipes" :componentUrls="categoriesUrls" />
                </Accordion>
            </div>
            <div class="col d-none d-md-block"></div>
        </div>
        <div class="row mt-2">
            <div class="col d-none d-md-block">
            </div>
            <div class="col-sm col-md-4">
                <div class="row">
                    <div class="regenerable col">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories">
                                    <td>{{ index + 1 }}</td>
                                    <td><a @click="selectCategory(category)">{{ category.name }}</a></td>
                                    <td>{{ category.recipes_count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col d-none d-md-block">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" v-for="category in categories">
            <button class="btn btn-danger" @click="selectCategory(category)">{{ category.name }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <Category :inCategory="selectedCategory" :recipes="recipes" :componentUrls="categoriesUrls" />
        </div>
    </div>
</template>

<style>
</style>