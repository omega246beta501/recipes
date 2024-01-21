<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    recipe: Object
})

const instructions = props.recipe.recipe_parts[0].instructions

onMounted(() => {
})

</script>


<template>
    <div class="col-12 card last-card">
        <div v-for="(instruction, index) in instructions" :key="index" class="row card-element">
            <div class="col-xs-11">
                <p style="margin-bottom: 8px; color: #898f9d;">Step {{ index + 1 }}</p>
                <span>{{ instruction.description }}</span>
            </div>
        </div>
    </div>
</template>
