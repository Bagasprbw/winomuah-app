<template>
  <div class="flex flex-col min-h-screen bg-[#fffaf2] text-gray-800">
    <Navbar />
    <main class="flex-1">
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from '../Components/Navbar.vue'
import Footer from '../Components/Footer.vue'
</script>
