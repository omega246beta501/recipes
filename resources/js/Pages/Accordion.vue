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
                <slot></slot>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            isExpanded: Boolean
        };
    },
    created() {
        this.isExpanded = false;
    },
    methods: {
        toggleAccordionItem() {
            this.isExpanded = !this.isExpanded;
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

/* Style your accordion item content */
.accordion-item-content {
  max-height: 0; /* Hide the content by default */
  overflow: hidden; /* Hide overflow */
  transition: max-height 0.3s ease, padding 0.3s ease; /* Add transition effect for smooth animation */
  padding: 0;
}

/* Style your expanded accordion item content */
.expanded {
  /* Add your styles here */
  max-height: 200px; /* Set the max height to show the content */
  transition: max-height 1s ease, padding 0.3s ease; /* Add transition effect for smooth animation */
  padding: 16px;
  overflow: visible;
}
</style>


  