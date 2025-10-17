<template>
  <AppLayout :company="company">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Dashboard</h1>
    <p>Selamat datang di panel admin!</p>
  </AppLayout>
</template>

<script setup>
import AppLayout from './AppLayout.vue'
import { defineProps } from 'vue'

const props = defineProps({
  company: Object
})
</script>
