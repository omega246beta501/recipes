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
        members: Array,
        selectedMember: Object,
    },
    mounted() {
    },
    beforeDestroy() {
    },
    methods: {
        isSelected(member) {
            return member.name == this.selectedMember.name
        },
        handleClick(member) {
            this.$emit('change-member', member)
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
            Choose payer
            <a @click="closeCard()" class="dismiss" href="#">×</a>
        </header>
        <div class="body">
            <ul>
                <li v-for="member in members" :key="member.name" @click="handleClick(member); closeCard()" :class="['main_payer', { selected: isSelected(member)}]">
                    <img src="https://s3.amazonaws.com/splitwise/uploads/user/default_avatars/avatar-blue28-50px.png">
                    {{ member.name }}
                </li>
            </ul>
            
        </div>
    </div>
</template>
