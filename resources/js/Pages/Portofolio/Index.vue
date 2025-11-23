<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-amber-50 to-white py-12 px-4">
      <div ref="headerRef" class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
          Portofolio Catalog
        </h1>
        <p class="text-lg text-gray-600">
          Explore our collection of handcrafted and unique items
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
      <div ref="filterRef" class="flex flex-wrap gap-3 mb-8">
        <div class="relative">
          <select
            v-model="sortBy"
            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all cursor-pointer"
          >
            <option value="latest">Sort by</option>
            <option value="name">Name (A-Z)</option>
            <option value="year">Year (Newest)</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>

        <div class="relative">
          <select
            v-model="categoryFilter"
            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all cursor-pointer"
          >
            <option value="all">Category</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
      </div>

      <TransitionGroup
        name="portofolios"
        tag="div"
        class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8"
      >
        <button
          v-for="portofolio in filteredPortofolios"
          :key="portofolio.id"
          @click="openModal(portofolio)"
          class="portofolio-card-anim group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-left w-full"
          :class="{ 'initial-hidden': isInitialLoad }"
        >
          <div class="aspect-video overflow-hidden bg-gray-100">
            <img
              v-if="portofolio.image"
              :src="portofolio.image"
              :alt="portofolio.title"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
              <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>

          <div class="p-5">
            <h3 class="font-bold text-gray-900 text-xl mb-2 line-clamp-1 group-hover:text-amber-600 transition-colors">
              {{ portofolio.title }}
            </h3>
            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
              {{ portofolio.category || 'Uncategorized' }}
            </p>
          </div>
        </button>
      </TransitionGroup>

      <div class="flex justify-center items-center gap-3 mt-8">
        <button
          class="w-10 h-10 rounded-full bg-amber-400 hover:bg-amber-500 text-white flex items-center justify-center transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
          disabled
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button
          class="w-10 h-10 rounded-full bg-amber-400 hover:bg-amber-500 text-white flex items-center justify-center transition-colors shadow-md hover:shadow-lg"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <div v-if="filteredPortofolios.length === 0" class="text-center py-16">
        <div class="text-gray-400 mb-4">
          <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No portofolio found</h3>
        <p class="text-gray-500">Try adjusting your filters</p>
      </div>
    </div>

    <WhatsAppFAB/>

    <PortofolioModal
      v-if="selectedPortofolio"
      :portofolio="selectedPortofolio"
      @close="closeModal"
    />
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';
import MainLayout from '../AppLayout.vue';
import PortofolioModal from '@/Components/PortofolioModal.vue';
import WhatsAppFAB from "@/Components/WhatsAppFAB.vue";
import { gsap } from "gsap";

// Props dari Laravel Controller
const props = defineProps({
  portofolios: Array
});

// State untuk filter
const sortBy = ref('latest');
const categoryFilter = ref('all');

// State untuk modal
const selectedPortofolio = ref(null);

// Flag untuk menangani FOUC (Flash of Unstyled Content)
const isInitialLoad = ref(true);

// Computed untuk portofolio yang difilter
const filteredPortofolios = computed(() => {
  let result = [...props.portofolios];

  // Filter by category
  if (categoryFilter.value !== 'all') {
    result = result.filter(p => p.category === categoryFilter.value);
  }

  // Sort
  if (sortBy.value === 'name') {
    result.sort((a, b) => a.title.localeCompare(b.title));
  } else if (sortBy.value === 'year') {
    result.sort((a, b) => {
      const yearA = parseInt(a.year) || 0;
      const yearB = parseInt(b.year) || 0;
      return yearB - yearA;
    });
  }

  return result;
});

// Extract unique categories dari portofolios
const categories = computed(() => {
  const cats = props.portofolios.map(p => p.category).filter(Boolean);
  return [...new Set(cats)];
});

// Function untuk buka modal
const openModal = (portofolio) => {
  selectedPortofolio.value = portofolio;
  document.body.style.overflow = 'hidden';
};

// Function untuk tutup modal
const closeModal = () => {
  selectedPortofolio.value = null;
  document.body.style.overflow = '';
};

// --- ANIMASI GSAP ---
const headerRef = ref(null);
const filterRef = ref(null);

onMounted(async () => {
  await nextTick(); // Tunggu DOM render selesai

  // 1. Siapkan Elemen
  if (headerRef.value) gsap.set(headerRef.value.children, { opacity: 0, y: 30 });
  if (filterRef.value) gsap.set(filterRef.value.children, { opacity: 0, y: 20 });

  const cards = document.querySelectorAll('.portofolio-card-anim');

  // 2. Jalankan Timeline
  const tl = gsap.timeline({ defaults: { ease: "power2.out" } });

  // Animasi Header
  if (headerRef.value) {
    tl.to(headerRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.1
    });
  }

  // Animasi Filter
  if (filterRef.value) {
    tl.to(filterRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1
    }, "-=0.6");
  }

  // Animasi Grid Portfolio
  if (cards.length > 0) {
    tl.to(cards, {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: "power2.out",
      onComplete: () => {
        isInitialLoad.value = false; // Hapus class hidden
        gsap.set(cards, { clearProps: "all" }); // Bersihkan style inline
      }
    }, "-=0.4");
  } else {
    isInitialLoad.value = false;
  }
});
</script>

<style scoped>
/* Class khusus untuk menyembunyikan element SAAT INITIAL LOAD SAJA */
.initial-hidden {
  opacity: 0;
  transform: translateY(30px);
}

/* Transition animations untuk portofolio cards */
.portofolios-enter-active,
.portofolios-leave-active {
  transition: all 0.5s ease;
  position: relative;
}

.portofolios-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.portofolios-leave-to {
  opacity: 0;
  transform: scale(0.9);
}

.portofolios-move {
  transition: transform 0.5s ease;
}

.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
