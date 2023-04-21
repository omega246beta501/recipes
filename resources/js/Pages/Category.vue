<script>
import Multiselect from 'vue-multiselect'
export default {

    components: { Multiselect },
    data() {
        return {
            selectedRecipes: [],
            attachedRecipes: [],
            category: {}
        }
    },
    created() {
        this.populateComponent()
    },
    watch: {
        inCategory() {
            this.populateComponent()
        }
    },
    props: {
        inCategory: {
            type: Object,
            required: false
        },
        recipes: {
            type: Array,
            required: true
        },
        componentUrls: {
            type: Object,
            required: true
        }
    },
    computed: {
        selectedRecipesIds() {
            var ids = []
            this.selectedRecipes.forEach(recipe => {
                ids.push(recipe.id)
            })
            return ids
        },
        mode() {
            if(this.inCategory) {
                return 'Modificar'
            } else {
                return 'Crear'
            }
        },
        putUrl() {
            if(this.inCategory) {
                return this.componentUrls.putUrl + '/' + this.inCategory.id
            } else {
                return this.componentUrls.putUrl
            }
        },
        populateUrl() {
            if(this.inCategory) {
                return this.componentUrls.populateUrl + '/' + this.inCategory.id
            }
            else {
                return this.componentUrls.populateUrl
            }
        }
    },
    methods: {
        populateComponent() {
            if(this.inCategory) {
                fetch(this.populateUrl)
                .then(response => response.json())
                .then(data => {
                    this.attachedRecipes = data.attachedRecipes
                    this.category = data.category
                    this.selectedRecipes = []
                    this.attachedRecipes.forEach(recipe => {
                        this.selectedRecipes.push(recipe)
                    })
                })
            }
        },
        putCategory() {

            var data = {
                "id": this.category.id,
                "recipesToAttach": this.selectedRecipesIds,
                "newName": this.category.name
            }

            fetch(this.putUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(data => {
                alert('Se ha actualizado la categoría en el sistema');
                location.reload();
            })
        }
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" placeholder="Nombre" v-model="category.name">
        </div>
        <div class="col">
            <multiselect v-model="selectedRecipes" :options="recipes" :multiple="true" :taggable="true" track-by="id" label="name" :hide-selected="true"></multiselect>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-10"></div>
        <div class="col">
            <button class="btn btn-success" @click="putCategory">{{ mode }}</button>
        </div>
    </div>
</template>
