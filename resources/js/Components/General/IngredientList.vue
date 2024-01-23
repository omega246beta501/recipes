<script>
export default {
    props: {
        ingredients: Array,
        isFromRecipes: {
            type: Boolean,
            default: true
        }
    },
    methods: {
        showAlert(string) {
            alert(string)
        }
    }
}


</script>
<style scoped>
.ingredient-card-element {
    /* margin: 15px; */
    padding: 0px 15px 0px 15px;
    overflow-wrap: anywhere;
    display: flex;
    align-items: center;
    min-height: 58px;
}

</style>

<template>
    <div class="col-12 card last-card">
        <div v-for="(ingredient, index) in ingredients" :key="index" class="row ingredient-card-element" @click="showAlert(ingredient.pivot.description)">
            <div class="col-xs-2" style="text-align: center;">
                <img v-if="ingredient.image_path" class="image" :src="`/${ingredient.image_path}`" loading="eager">
                <div v-else class="no-image">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path d="m16.736 9.252-3.982-5.876A.907.907 0 0 0 12 3a.892.892 0 0 0-.755.385L7.264 9.252H2.909c-.5 0-.909.403-.909.896 0 .08.01.16.036.241l2.31 8.303C4.554 19.445 5.254 20 6.09 20h11.818c.837 0 1.537-.555 1.755-1.308l2.309-8.303.027-.241a.905.905 0 0 0-.91-.896h-4.354Zm-7.463 0L12 5.31l2.727 3.94H9.273ZM12 16.417c-1 0-1.818-.806-1.818-1.791 0-.985.818-1.791 1.818-1.791s1.818.806 1.818 1.79c0 .986-.818 1.792-1.818 1.792Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-xs-10" style="padding-left: 5px;">
                <span>
                    {{ ingredient.name }}
                    <strong>
                        {{ ingredient.pivot.qty }}
                        <span v-if="isFromRecipes && ingredient.pivot.description"> ({{ ingredient.pivot.description }}) </span>
                    </strong>
                </span>
            </div>
        </div>
    </div>
</template>
