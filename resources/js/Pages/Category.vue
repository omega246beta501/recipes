<script>
import Multiselect from 'vue-multiselect'
export default {

    components: { Multiselect },
    data() {
        return {
            selectedRecipes: []
        }
    },
    props: {
        recipes: {
            type: Array,
            required: true
        },
        attachedRecipes: {
            type: Array,
            required: true
        },
        category: {
            type: Object,
            required: false
        },
        url: {
            type: String,
            required: true
        }
    },
    created() {
        this.attachedRecipes.forEach(recipe => {
            this.selectedRecipes.push(recipe)
        })
    },
    computed: {
        categoryName() {
            if(this.category) {
                return this.category.name
            }
            else {
                return ''
            }
        },
        selectedRecipesIds() {
            var ids = []
            this.selectedRecipes.forEach(recipe => {
                ids.push(recipe.id)
            })
            return ids
        }
    },
    watch: {
        selectedRecipesIds: function (val) {
            console.log(val)
        }
    },
    methods: {
        updateCategory() {

            var data = {
                "id": this.category.id,
                "recipesToAttach": this.selectedRecipesIds,
                "newName": this.categoryName
            }

            var settings = {
                "async": true,
                "crossDomain": true,
                "url": this.url,
                "method": "POST",
                "headers": {
                    "cache-control": "no-cache",
                    "postman-token": "beeffe31-037f-448b-b45a-382e3b7c8e1c"
                },
                "data": JSON.stringify(data)
            }

            $.ajax(settings).done(function(response) {
                alert('Se ha actualizado la categoría en el sistema');
                location.reload();
            });
        }
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <div class="row">
        <div class="col">
            <input class="form-control" type="text" placeholder="Nombre" v-model="categoryName">
        </div>
        <div class="col">
            <multiselect v-model="selectedRecipes" :options="recipes" :multiple="true" :taggable="true" track-by="id" label="name"></multiselect>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-10"></div>
        <div class="col">
            <button v-if="category" class="btn btn-success" @click="updateCategory">Modificar</button>
            <button v-else class="btn btn-success" onclick="">Crear</button>
        </div>
    </div>
</template>
