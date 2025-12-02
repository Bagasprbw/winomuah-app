<template>
  <AppLayout :company="company">
    <div class="w-full py-32 flex justify-center">

      <div class="text-center max-w-4xl px-4 space-y-6">

        <!-- Label -->
        <span class="inline-block px-6 py-2 text-lg font-bold 
                     bg-yellow-100 text-yellow-700 rounded-full shadow animate-float">
          ADMIN PANEL
        </span>

        <!-- Title -->
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 drop-shadow-lg">
          Selamat Datang 👋
        </h1>

        <!-- Subtitle -->
        <p class="text-xl md:text-2xl text-gray-600 font-light">
          Senang bertemu kembali, semoga harimu menyenangkan ✨
        </p>

        <!-- Yellow line -->
        <div class="mt-4 w-36 h-1.5 bg-yellow-400 mx-auto rounded-full animate-lineGrow"></div>

        <!-- Company Name -->
        <p class="text-lg md:text-xl font-semibold text-gray-700 mt-4">
          {{ company?.nama }}
        </p>

      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from './AppLayout.vue'
import { defineProps } from 'vue'

const props = defineProps({
  company: Object
})
</script>

<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
.animate-float { animation: float 3s ease-in-out infinite; }

@keyframes lineGrow {
  0% { width: 0; opacity: 0; }
  100% { width: 9rem; opacity: 1; }
}
.animate-lineGrow { animation: lineGrow 1.5s ease-out forwards; }
</style>
