<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const page = usePage()
const isMobileOpen = ref(false)

// ambil path saat ini
const currentPath = computed(() => page.url.split('?')[0])

/**
 * Scroll halus ke section (hero/contact/portfolio)
 * - Jika sudah di halaman Home → langsung scroll.
 * - Jika di halaman lain → pindah ke Home, lalu scroll otomatis.
 */
const scrollToSection = (id) => {
  const isHome = currentPath.value === '/'
  isMobileOpen.value = false

  const doScroll = (targetId) => {
    setTimeout(() => {
      if (targetId === 'hero') {
        window.scrollTo({ top: 0, behavior: 'smooth' })
        return
      }

      const section = document.getElementById(targetId)
      if (section) {
        const navbarHeight = 80
        const sectionTop = section.getBoundingClientRect().top + window.scrollY

        window.scrollTo({
          top: sectionTop - navbarHeight,
          behavior: 'smooth',
        })
      }
    }, 400)
  }

  if (isHome) {
    doScroll(id)
  } else {
    router.visit('/', {
      onFinish: () => doScroll(id),
    })
  }
}

// helper active link
const isActive = (path) => currentPath.value === path
</script>

<template>
  <header
    class="bg-white/80 backdrop-blur-md shadow-md sticky top-0 z-50 transition-all duration-300"
  >
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div
        class="flex items-center space-x-2 cursor-pointer"
        @click="scrollToSection('hero')"
      >
        <img
          src="/public/assets/Logo.png"
          alt="Winomuah Logo"
          class="w-8 h-8 rounded-full object-cover"
        />
        <h1 class="text-xl font-bold text-gray-800">Winomuah Store</h1>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
        <!-- Home -->
        <button
          @click="scrollToSection('hero')"
          :class="[
            'transition-colors duration-300',
            isActive('/') ? 'text-yellow-500 font-semibold' : 'hover:text-yellow-500',
          ]"
        >
          Home
        </button>

        <!-- Products -->
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

        <!-- Portfolio -->
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

        <!-- Contact -->
        <button
          @click="scrollToSection('contact')"
          class="hover:text-yellow-500 transition-colors duration-300"
        >
          Contact
        </button>
      </nav>

      <!-- Mobile Toggle -->
      <button
        @click="isMobileOpen = !isMobileOpen"
        class="md:hidden text-yellow-500 focus:outline-none"
      >
        <i :class="isMobileOpen ? 'fa fa-times' : 'fa fa-bars'"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <transition name="fade">
      <div
        v-if="isMobileOpen"
        class="md:hidden bg-white border-t border-gray-100 shadow-inner"
      >
        <nav class="flex flex-col p-4 space-y-3 text-gray-700 font-medium">
          <button
            @click="scrollToSection('hero')"
            :class="isActive('/') ? 'text-yellow-500 font-semibold' : ''"
          >
            Home
          </button>

          <Link
            href="/products"
            :class="isActive('/products') ? 'text-yellow-500 font-semibold' : ''"
            @click="isMobileOpen = false"
          >
            Products
          </Link>

          <Link
            href="/portofolio"
            :class="isActive('/portofolio') ? 'text-yellow-500 font-semibold' : ''"
            @click="isMobileOpen = false"
          >
            Portfolio
          </Link>

          <button
            @click="scrollToSection('contact')"
            class="hover:text-yellow-500 transition"
          >
            Contact Me
          </button>
        </nav>
      </div>
    </transition>
  </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
