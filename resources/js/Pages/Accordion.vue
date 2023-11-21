<template>
    <div class="accordion">
        <div class="card">
            <div class="card-header" @click="toggleAccordionItem()">
                <h5 class="mb-0">
                    <button class="btn">
                        {{ title }}
                    </button>
                </h5>
            </div>
            <div class="card-body accordion-item-content" :class="{ 'expanded': isExpanded }">
                <Transition @after-enter="onAfterEnter" @leave="onLeave">
                    <div v-show="showAccordion">
                        <slot></slot>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            isExpanded: Boolean,
            showAccordion: Boolean
        };
    },
    created() {
        this.isExpanded = false
        this.showAccordion = false
    },
    methods: {
        toggleAccordionItem() {
            this.showAccordion = !this.showAccordion
        },
        onAfterEnter() {
            this.isExpanded = true
        },
        onLeave() {
            this.isExpanded = false
        }
    },
    props: {
        title: {
            type: String,
            required: true
        }
    }
};
</script>
  
<style scoped>

/* Style your accordion item header */
.accordion-item-header {
  /* Add your styles here */
  cursor: pointer; /* Add cursor style for better UX */
}

/* .v-enter-from {
    max-height: 0;
    padding: 0;
    overflow: hidden;
}
.v-leave-to {
    max-height: 200px;
    overflow: visible;
    padding: 16px;
}

.v-enter-active,
.v-leave-active {
    transition: max-height 0.3s ease, padding 0.3s ease;
} */
.v-enter-active,
.v-leave-active {
    transition: max-height 0.5s ease, padding 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    max-height: 0;
    padding: 0;
}
.v-enter-to,
.v-leave-from {
    max-height: 200px;
    padding: 16px;
}

.accordion-item-content {
    overflow: hidden; 
    padding: 0;
}

.expanded {
    padding: 16px;
    overflow: visible;
}
</style>


  