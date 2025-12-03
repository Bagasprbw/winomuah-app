<template>
  <div class="flex h-screen bg-[#fffaf3]">
    <!-- Overlay untuk mobile -->
    <div
      v-if="showMobileMenu"
      @click="showMobileMenu = false"
      class="fixed inset-0 bg-black/50 z-40 md:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'w-64 bg-white/70 backdrop-blur-lg shadow-lg flex flex-col border-r fixed h-full z-50 transition-transform duration-300',
        showMobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
      ]"
    >
      <!-- Logo & Name -->
      <div class="flex items-center space-x-2 px-4 md:px-6 py-4 border-b">
        <img :src="`/storage/${company.logo}`" alt="Logo" class="w-8 h-8 object-contain" />
        <div class="flex-1 min-w-0">
          <h1 class="font-bold text-lg text-gray-800 truncate">{{ company.company_name }}</h1>
          <p class="text-sm text-gray-500">Admin</p>
        </div>
        <!-- Close button untuk mobile -->
        <button
          @click="showMobileMenu = false"
          class="md:hidden text-gray-500 hover:text-gray-700"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 p-4 space-y-2 mt-4 overflow-y-auto">
        <Link
          href="/admin/company"
          class="menu-item"
          :class="{ active: $page.url.startsWith('/admin/company') }"
          @click="showMobileMenu = false"
        >
          <UserRoundPen alt="Company" class="w-5 h-5 flex-shrink-0" />
          <span class="truncate">Company</span>
        </Link>

        <Link
          href="/admin/dashboard"
          class="menu-item"
          :class="{ active: $page.url.startsWith('/admin/dashboard') }"
          @click="showMobileMenu = false"
        >
          <House alt="Dashboard" class="w-5 h-5 flex-shrink-0" />
          <span class="truncate">Dashboard</span>
        </Link>

        <Link
          href="/admin/products"
          class="menu-item"
          :class="{ active: $page.url.startsWith('/admin/products') }"
          @click="showMobileMenu = false"
        >
          <ShoppingBag alt="Products" class="w-5 h-5 flex-shrink-0" />
          <span class="truncate">Products</span>
        </Link>

        <Link
          href="/admin/portofolio"
          class="menu-item"
          :class="{ active: $page.url.startsWith('/admin/portofolio') }"
          @click="showMobileMenu = false"
        >
          <Images alt="portofolio" class="w-5 h-5 flex-shrink-0" />
          <span class="truncate">Portofolio</span>
        </Link>
      </nav>

      <!-- 🔒 Logout Button -->
      <div class="p-4 border-t mt-auto">
        <Link
          href="/logout"
          method="post"
          as="button"
          class="w-full flex items-center justify-center space-x-2 bg-[#f9a825] text-white py-2 rounded-lg font-medium hover:bg-[#f57f17] transition"
          @click="showMobileMenu = false"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
          </svg>
          <span>Logout</span>
        </Link>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 md:ml-64 p-4 md:p-6 overflow-y-auto relative">
      <!-- Mobile header dengan hamburger menu -->
      <header
        class="fixed top-0 left-0 right-0 md:left-64 bg-white/70 backdrop-blur-md shadow-sm h-16 md:h-20 flex items-center justify-between px-4 md:px-8 z-30"
      >
        <!-- Hamburger button untuk mobile -->
        <button
          @click="showMobileMenu = true"
          class="md:hidden text-gray-700 hover:text-[#f9a825] p-1"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- Judul -->
        <h2 class="text-xl md:text-2xl font-bold text-[#f9a825] capitalize mx-auto md:mx-0">
          Admin Panel
        </h2>

        <!-- Spacer untuk balance layout di mobile -->
        <div class="w-6 md:hidden"></div>
      </header>

      <div class="mt-16 md:mt-20 relative">
        <!-- 🔔 Global Alert -->
        <Alert />

        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import Alert from '@/Components/Alert.vue'
import { UserRoundPen, House, ShoppingBag, Images } from 'lucide-vue-next'

const props = defineProps({
  company: Object
})

const showMobileMenu = ref(false)

// Close mobile menu ketika resize ke desktop
const handleResize = () => {
  if (window.innerWidth >= 768) {
    showMobileMenu.value = false
  }
}

// Keyboard escape untuk close menu
const handleEscape = (e) => {
  if (e.key === 'Escape' && showMobileMenu.value) {
    showMobileMenu.value = false
  }
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
  window.addEventListener('keydown', handleEscape)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
  window.removeEventListener('keydown', handleEscape)
})
</script>

<style scoped>
.menu-item {
  @apply flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-[#fff3e0] transition;
}
.menu-item.active {
  @apply bg-[#ffe8c9] text-[#f9a825] font-semibold;
}

/* Smooth scrolling untuk mobile */
nav {
  -webkit-overflow-scrolling: touch;
}

/* Animasi untuk overlay */
.fixed.inset-0 {
  transition: opacity 0.3s ease;
}
</style>
