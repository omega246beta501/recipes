<script>
export default {
    data() {
        return {
            names: ['Emil, Hans', 'Mustermann, Max', 'Tisch, Roman'],
            selected: '',
            prefix: '',
            first: '',
            last: ''
        }
    }
}
</script>

<template>
    <div><input v-model="prefix" placeholder="Filter prefix"></div>
    <p>
        hijo de puta {{ prefix }}
    </p>
</template>

<style>
* {
    font-size: inherit;
}

input {
    display: block;
    margin-bottom: 10px;
}

select {
    float: left;
    margin: 0 1em 1em 0;
    width: 14em;
}

.buttons {
    clear: both;
}

button+button {
    margin-left: 5px;
}
</style>