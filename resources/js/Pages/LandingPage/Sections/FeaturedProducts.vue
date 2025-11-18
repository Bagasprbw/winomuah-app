<template>
  <section ref="sectionRef" class="py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 ref="titleRef" class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
        Featured Products
      </h2>

      <div
        ref="gridRef"
        v-if="products.length"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8"
      >
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="{
            title: product.name,
            image: product.image || '/assets/placeholder.png',
            price: `Rp ${Number(product.price).toLocaleString('id-ID')}`,
          }"
          @click="$emit('open-modal', product)"
          class="cursor-pointer"/>
      </div>

      <p v-else class="text-gray-500 text-center text-lg italic mt-6">
        Belum ada produk yang tersedia.
      </p>

      <div ref="buttonRef" class="flex justify-center mt-12">
        <Link
          href="/products"
          class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-3 rounded-xl transition-all duration-300"
        >
          View Full Catalog
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
// --- Import Bawaan ---
import { Link } from '@inertiajs/vue3';
import ProductCard from "@/Components/ProductCard.vue";

// --- Import Baru untuk Animasi ---
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

// --- Props & Emits ---
defineProps({ products: Array });
defineEmits(['open-modal']);

// --- Logika Animasi GSAP
const sectionRef = ref(null);
const titleRef = ref(null);
const gridRef = ref(null);
const buttonRef = ref(null);

onMounted(() => {
  // 1. Sembunyikan semua elemen secara terpisah
  gsap.set(titleRef.value, { opacity: 0, y: 30 });
  gsap.set(buttonRef.value, { opacity: 0, y: 30 });

  if (gridRef.value) {
    gsap.set(gridRef.value.children, { opacity: 0, y: 30 });
  }

  // 2. Buat timeline dengan ScrollTrigger
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: sectionRef.value,
      start: "top 85%",
      toggleActions: "play none none reverse",
    }
  });

  // 3. (PERTAMA) Animasikan judul saja
  tl.to(titleRef.value, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  });

  // 4. (KEDUA) Animasikan card-cardnya (stagger)
  if (gridRef.value) {
    tl.to(gridRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: "power2.out"
    }, "-=0.5"); 
  }

  // 5. (KETIGA) Animasikan tombol "View Full Catalog"
  tl.to(buttonRef.value, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  }, "-=0.3");
});
</script>
