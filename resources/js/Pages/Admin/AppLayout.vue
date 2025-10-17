<template>
  <div class="flex h-screen bg-[#fffaf3]">
    <!-- Sidebar -->
    <aside
      class="w-64 bg-white/70 backdrop-blur-lg shadow-lg flex flex-col border-r fixed h-full"
    >
      <!-- Logo & Name -->
      <div class="flex items-center space-x-2 px-6 py-4 border-b">
        <img :src="`/storage/${company.logo}`" alt="Logo" class="w-8 h-8 object-contain" />
        <div>
          <h1 class="font-bold text-lg text-gray-800">{{ company.company_name }}</h1>
          <p class="text-sm text-gray-500">Admin</p>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 p-4 space-y-2 mt-4">
        <Link href="/admin/company" class="menu-item" :class="{ active: $page.url.startsWith('/admin/company') }">
          <img :src="companyIcon" alt="Company" class="w-5 h-5" />
          <span>Company</span>
        </Link>

        <Link href="/admin/dashboard" class="menu-item" :class="{ active: $page.url.startsWith('/admin/dashboard') }">
          <img :src="dashboardIcon" alt="Dashboard" class="w-5 h-5" />
          <span>Dashboard</span>
        </Link>

        <Link href="/admin/products" class="menu-item" :class="{ active: $page.url.startsWith('/admin/products') }">
          <img :src="productIcon" alt="Products" class="w-5 h-5" />
          <span>Products</span>
        </Link>

        <Link href="/admin/portfolio" class="menu-item" :class="{ active: $page.url.startsWith('/admin/portfolio') }">
          <img :src="portfolioIcon" alt="Portfolio" class="w-5 h-5" />
          <span>Portfolio</span>
        </Link>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 ml-64 p-6 overflow-y-auto relative">
      <header
        class="fixed top-0 left-64 right-0 bg-white/70 backdrop-blur-md shadow-sm h-16 flex items-center justify-between px-8 z-10"
      >
        <h2 class="text-2xl font-bold text-[#f9a825] capitalize">Admin Panel</h2>
        <div class="flex items-center space-x-3">
          <img :src="`/storage/${company.logo}`" alt="Profile" class="w-8 h-8 rounded-full object-cover" />
          <span class="font-medium text-gray-700">{{ company.company_name }}</span>
        </div>
      </header>

      <div class="mt-20 relative">
        <!-- 🔔 Global Alert -->
        <Alert />

        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import Alert from '@/Components/Alert.vue'

import dashboardIcon from './Components/dashbaord-icon.png'
import companyIcon from './Components/comp-icon.png'
import productIcon from './Components/prod-icon.png'
import portfolioIcon from './Components/port-icon.png'

const props = defineProps({
  company: Object
})
</script>

<style scoped>
.menu-item {
  @apply flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-[#fff3e0] transition;
}
.menu-item.active {
  @apply bg-[#ffe8c9] text-[#f9a825] font-semibold;
}
</style>
