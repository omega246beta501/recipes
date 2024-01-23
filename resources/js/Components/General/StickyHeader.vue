<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    name: String,
    backRoute: String
})

onMounted(() => {
})

</script>

<style scoped>
.sticky-top {
    padding: 15px;
    position: sticky;
    top: 0;
}

.sticky-header {
    justify-content: center;
    flex-direction: column;
    display: flex;
    font-size: 22px;
    font-weight: 500;
}

.sticky-header-items {
    align-items: center;
    display: inherit;
}

.special-button {
    fill: #233748;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    line-height: 0;
    background: transparent;
    border: none;
    padding: 0;
}

</style>
<template>
    <div class="sticky-top">
        <div class="row" style="margin-bottom: 25px;">
            <div class="col-12">
                <div class="row sticky-header">
                    <div class="sticky-header-items">
                        <a :href="backRoute" class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M20 12a1 1 0 0 0-1-1H7.83l4.88-4.88a1 1 0 0 0-1.415-1.415l-6.588 6.588a1 1 0 0 0 0 1.414l6.588 6.588a.997.997 0 0 0 1.41-1.41L7.83 13H19a1 1 0 0 0 1-1Z"></path>
                                </svg>
                            </button>
                        </a>
                        <div class="col-xs-10" style="margin-left: 15px;">{{ name }}</div>
                        <div class="col-xs-1">
                            <button class="special-button" type="button">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M7.99 12c0-1.105-.893-2-1.995-2A1.997 1.997 0 0 0 4 12c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM13.975 12c0-1.105-.893-2-1.995-2a1.997 1.997 0 0 0-1.995 2c0 1.105.893 2 1.995 2a1.997 1.997 0 0 0 1.995-2ZM17.965 10c1.102 0 1.995.895 1.995 2s-.893 2-1.995 2a1.997 1.997 0 0 1-1.995-2c0-1.105.893-2 1.995-2Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <slot></slot>
    </div>
</template>
