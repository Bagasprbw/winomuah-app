<template>
  <section ref="sectionRef" id="portofolio" class="py-20 px-4 md:px-8 bg-gradient-to-b from-amber-50 to-white">
    <div class="max-w-7xl mx-auto">
      <h2 ref="titleRef" class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
        Portofolio
      </h2>

      <div
        ref="gridRef"
        v-if="portofolios.length"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
      >
        <PortofolioCard
          v-for="portofolio in portofolios"
          :key="portofolio.id"
          :portofolio="{
            title: portofolio.title,
            description: portofolio.description,
            image: portofolio.image || '/assets/placeholder.png',
          }"
          @click="$emit('open-modal', portofolio)"
          class="cursor-pointer"
        />
      </div>

      <p v-else class="text-gray-500 text-center text-lg italic mt-6">
        Belum ada portofolio yang tersedia.
      </p>

      <div ref="buttonRef" class="flex justify-center mt-12">
        <Link
          href="/portofolio"
          class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-3 rounded-xl transition-all duration-300"
        >
          View Full Portofolio
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
// --- Import Bawaan ---
import { Link } from "@inertiajs/vue3";
import PortofolioCard from "@/Components/PortofolioCard.vue";

// --- Import Baru untuk Animasi ---
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

// --- Props & Emits ---
defineProps({ portofolios: Array });
defineEmits(['open-modal']);

// --- Logika Animasi GSAP ---
const sectionRef = ref(null);
const titleRef = ref(null);
const gridRef = ref(null);
const buttonRef = ref(null);

onMounted(() => {
  // Sembunyikan semua elemen di awal
  gsap.set(titleRef.value, { opacity: 0, y: 30 });
  gsap.set(buttonRef.value, { opacity: 0, y: 30 });
  if (gridRef.value) {
    gsap.set(gridRef.value.children, { opacity: 0, y: 30 });
  }

  // Buat timeline dengan ScrollTrigger
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: sectionRef.value,
      start: "top 85%",
      toggleActions: "play none none reverse",
    }
  });

  // Animasikan judul
  tl.to(titleRef.value, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  });

  // Animasikan card (stagger)
  if (gridRef.value) {
    tl.to(gridRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: "power2.out"
    }, "-=0.5");
  }

  tl.to(buttonRef.value, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  }, "-=0.3"); 
});
</script>
