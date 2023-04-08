<script setup>
import { Head } from '@inertiajs/inertia-vue3';
const props = defineProps(['user']);
</script>
 
<template>
    <Head title="User Profile" />
    <div>
        Hello {{ user }}
    </div>
    
</template>