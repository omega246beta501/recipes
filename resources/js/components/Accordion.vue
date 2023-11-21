<script>
export default {
    data() {
        return {
        }
    },
    props: {
        accordionId: {
            type: String,
            required: true
        },
        accordionButtonId: {
            type: String,
            required: true
        },
        buttonName: {
            type: String,
            required: true
        }
    },
}
</script>

<template>
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn" id="{{ $accordionButtonId }}" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{ buttonName }}
                </button>
            </h5>
        </div>

        <div id="{{ $accordionId }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<style>
</style>