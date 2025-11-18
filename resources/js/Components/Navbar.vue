<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const logoImage = '/assets/Logo.png';

const page = usePage()
const isMobileOpen = ref(false)

// Ambil path saat ini
const currentPath = computed(() => page.url.split('?')[0])

/**
 * Scroll halus ke section (hero/contact/portfolio)
 */
const scrollToSection = (id) => {
  const isHome = currentPath.value === '/'
  isMobileOpen.value = false // Tutup menu mobile otomatis

  const doScroll = (targetId) => {
    setTimeout(() => {
      if (targetId === 'hero') {
        window.scrollTo({ top: 0, behavior: 'smooth' })
        return
      }

      // Pastikan ID-nya sesuai (misal "contact", "portfolio", dll)
      const section = document.getElementById(targetId)
      if (section) {
        const navbarHeight = 80 // Sesuaikan tinggi navbar
        const sectionTop = section.getBoundingClientRect().top + window.scrollY

        window.scrollTo({
          top: sectionTop - navbarHeight,
          behavior: 'smooth',
        })
      }
    }, 400) // Waktu tunggu agar router.visit selesai
  }

  if (isHome) {
    doScroll(id)
  } else {
    router.visit('/', {
      onFinish: () => doScroll(id),
    })
  }
}

// Helper active link
const isActive = (path) => currentPath.value === path
</script>

<template>
  <header
    class="bg-white/80 backdrop-blur-md shadow-md sticky top-0 z-50 transition-all duration-300 relative"
  >
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div
        class="flex items-center space-x-2 cursor-pointer"
        @click="scrollToSection('hero')"
      >
        <img
          :src="logoImage"
          alt="Winomuah Logo"
          class="w-8 h-8 rounded-full object-cover"
        />
        <h1 class="text-xl font-bold text-gray-800">Winomuah Store</h1>
      </div>

      <!-- Navbar Desktop -->
      <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
        <button
          @click="scrollToSection('hero')"
          :class="[
            'transition-colors duration-300',
            isActive('/') ? 'text-yellow-500 font-semibold' : 'hover:text-yellow-500',
          ]"
        >
          Home
        </button>

        <Link
          href="/products"
          :class="[
            'transition-colors duration-300',
            isActive('/products')
              ? 'text-yellow-500 font-semibold'
              : 'hover:text-yellow-500',
          ]"
        >
          Products
        </Link>

        <Link
          href="/portofolio"
          :class="[
            'transition-colors duration-300',
            isActive('/portofolio')
              ? 'text-yellow-500 font-semibold'
              : 'hover:text-yellow-500',
          ]"
        >
          Portfolio
        </Link>

        <button
          @click="scrollToSection('contact')"
          class="hover:text-yellow-500 transition-colors duration-300"
        >
          Contact
        </button>
      </nav>

      <!-- Toggle Mobile -->
      <button
        @click="isMobileOpen = !isMobileOpen"
        class="md:hidden text-yellow-500 focus:outline-none w-8 h-8 flex items-center justify-center"
        aria-label="Toggle menu"
      >
        <svg
          v-if="isMobileOpen"
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2.5"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
        <svg
          v-else
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2.5"
            d="M4 6h16M4 12h16m-7 6h7"
          />
        </svg>
      </button>
    </div>

    <!-- Navbar Mobile -->
    <transition name="slide-fade">
      <div
        v-if="isMobileOpen"
        class="md:hidden absolute top-full left-0 right-0 z-40 bg-white shadow-xl rounded-b-2xl overflow-hidden border-t border-gray-100"
      >
        <nav class="flex flex-col items-start p-6 space-y-4 text-gray-700 font-medium">
          <button
            @click="scrollToSection('hero')"
            :class="[
              'w-full text-left',
              isActive('/') ? 'text-yellow-500 font-semibold' : '',
            ]"
          >
            Home
          </button>

          <Link
            href="/products"
            :class="[
              'w-full text-left',
              isActive('/products') ? 'text-yellow-500 font-semibold' : '',
            ]"
            @click="isMobileOpen = false"
          >
            Products
          </Link>

          <Link
            href="/portofolio"
            :class="[
              'w-full text-left',
              isActive('/portofolio') ? 'text-yellow-500 font-semibold' : '',
            ]"
            @click="isMobileOpen = false"
          >
            Portfolio
          </Link>

          <button
            @click="scrollToSection('contact')"
            class="w-full text-left hover:text-yellow-500 transition"
          >
            Contact
          </button>
        </nav>
      </div>
    </transition>
  </header>
</template>

<style scoped>
/* Transisi slide-fade */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease-out;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
