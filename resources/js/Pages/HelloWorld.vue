<template>
  <app-layout>
    <h1 slot="header">Hello, World!</h1>
    <hello-world />
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  components: {
    HelloWorld,
  },
}
</script>
