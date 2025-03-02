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
        groups: Array,
        selectedGroup: Object,
    },
    mounted() {
    },
    beforeDestroy() {
    },
    methods: {
        isSelected(group) {
            return group.id == this.selectedGroup.id
        },
        handleClick(group) {
            this.$emit('change-group', group)
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
            Choose group
            <a @click="closeCard()" class="dismiss" href="#">×</a>
        </header>
        <div class="body">
            <ul>
                <li v-for="group in groups" :key="group.id" @click="handleClick(group); closeCard()" :class="{selected: isSelected(group)}">
                    {{ group.name }}
                </li>
            </ul>
            
        </div>
    </div>
</template>
