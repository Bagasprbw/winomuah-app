<template>
  <footer ref="footerRef" class="bg-[#fff3da] text-center py-6 text-gray-700 border-t">

    <!-- Sosial Media -->
    <div class="flex justify-center space-x-4 mb-3">

      <!-- TikTok (belum ada di DB) -->
      <a
        href="#"
        class="hover:text-black transition"
        aria-label="TikTok"
      >
        <i class="fa-brands fa-tiktok text-xl"></i>
      </a>

      <!-- Instagram Dinamis -->
      <a
        v-if="company.instagram"
        :href="`https://instagram.com/${company.instagram}`"
        target="_blank"
        rel="noopener noreferrer"
        class="hover:text-pink-600 transition"
        aria-label="Instagram"
      >
        <i class="fa-brands fa-instagram text-xl"></i>
      </a>

    </div>

    <!-- Nama Company -->
    <p class="text-sm">
      &copy; {{ currentYear }} {{ company.company_name ?? 'Company Name' }}. All rights reserved.
    </p>

    <!-- Alamat Company -->
    <p class="text-sm">
      {{ company.address ?? 'Alamat belum diatur' }}
    </p>

  </footer>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { gsap } from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

// Register ScrollTrigger
gsap.registerPlugin(ScrollTrigger)

// Ambil data company dari Inertia
const page = usePage()
const company = computed(() => page.props.company ?? {})

// Tahun otomatis
const currentYear = new Date().getFullYear()

// Animasi
const footerRef = ref(null)

onMounted(() => {
  if (footerRef.value && footerRef.value.children) {

    gsap.set(footerRef.value.children, { opacity: 0, y: 30 })

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: footerRef.value,
        start: "top 95%",
        toggleActions: "play none none reverse",
      }
    })

    tl.to(footerRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.15,
      ease: "power2.out"
    })
  }
})
</script>
