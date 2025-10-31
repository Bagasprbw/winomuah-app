<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { gsap } from 'gsap';

// Props
const props = defineProps({
  portofolio: Object
});

// Emits
const emit = defineEmits(['close']);

// Refs for animations
const modalRef = ref(null);
const backdropRef = ref(null);
const contentRef = ref(null);

// State untuk gambar yang dipilih
const selectedImage = ref(props.portofolio.image);

// Array thumbnail images (main image + duplicates untuk demo)
const thumbnails = [
  props.portofolio.image,
  props.portofolio.image,
  props.portofolio.image
].filter(Boolean);

// Function untuk ganti gambar utama
const selectImage = (imageUrl) => {
  // Animate image change with GSAP
  gsap.to('.main-image', {
    opacity: 0,
    scale: 0.95,
    duration: 0.2,
    onComplete: () => {
      selectedImage.value = imageUrl;
      gsap.to('.main-image', {
        opacity: 1,
        scale: 1,
        duration: 0.3,
        ease: 'back.out(1.7)'
      });
    }
  });
};

// Function untuk close modal
const closeModal = () => {
  // Animate out
  gsap.to('.modal-left', {
    x: -50,
    opacity: 0,
    duration: 0.3,
    ease: 'power2.in'
  });

  gsap.to('.modal-right', {
    x: 50,
    opacity: 0,
    duration: 0.3,
    ease: 'power2.in'
  });

  gsap.to(backdropRef.value, {
    opacity: 0,
    duration: 0.3,
    ease: 'power2.in',
    onComplete: () => {
      emit('close');
    }
  });
};

// Function untuk handle ESC key
const handleEscape = (e) => {
  if (e.key === 'Escape') {
    closeModal();
  }
};

// GSAP Animations
const animateIn = () => {
  nextTick(() => {
    // Backdrop fade in
    gsap.fromTo(backdropRef.value,
      { opacity: 0 },
      { opacity: 1, duration: 0.4, ease: 'power2.out' }
    );

    // Modal scale and fade in
    gsap.fromTo(contentRef.value,
      { scale: 0.9, opacity: 0 },
      { scale: 1, opacity: 1, duration: 0.5, ease: 'power3.out' }
    );

    // Animate left side (images) from left
    gsap.fromTo('.modal-left',
      { x: -50, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.6,
        ease: 'power3.out',
        delay: 0.2
      }
    );

    // Animate right side (info) from right
    gsap.fromTo('.modal-right',
      { x: 50, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.6,
        ease: 'power3.out',
        delay: 0.2
      }
    );

    // Stagger info items
    gsap.fromTo('.info-item',
      { opacity: 0, y: 15 },
      {
        opacity: 1,
        y: 0,
        duration: 0.4,
        stagger: 0.08,
        ease: 'power2.out',
        delay: 0.5
      }
    );
  });
};

// Lifecycle hooks
onMounted(() => {
  document.addEventListener('keydown', handleEscape);
  animateIn();
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
});
</script>

<template>
  <div>
    <!-- Backdrop -->
    <div
      ref="backdropRef"
      class="fixed inset-0 bg-black/70 backdrop-blur-md z-50"
      @click="closeModal"
    ></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-6 pointer-events-none">
      <div
        ref="contentRef"
        class="bg-[#FAF8F3] rounded-3xl shadow-2xl w-full max-w-6xl max-h-[85vh] overflow-hidden pointer-events-auto relative"
        @click.stop
      >
        <!-- Close Button -->
        <button
          @click="closeModal"
          class="absolute top-6 right-6 w-11 h-11 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 group z-20"
          aria-label="Close modal"
        >
          <svg class="w-5 h-5 text-gray-700 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 h-full overflow-y-auto overflow-x-hidden">
          <!-- Left Side - Images -->
          <div class="modal-left bg-white p-8 lg:p-12 flex flex-col justify-center">
            <!-- Main Image -->
            <div class="w-full max-w-md rounded-2xl overflow-hidden bg-gray-100 shadow-xl mx-auto">
              <img
                v-if="selectedImage"
                :src="selectedImage"
                :alt="portofolio.title"
                class="main-image w-full h-full object-cover"
              />
              <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Right Side - Info -->
          <div class="modal-right bg-[#FAF8F3] p-8 lg:p-12 flex flex-col justify-center">
            <div class="space-y-8 max-w-lg">
              <!-- Breadcrumb -->
              <nav class="info-item flex items-center gap-2 text-sm">
                <span class="text-amber-600 hover:text-amber-700 font-semibold cursor-pointer transition-colors">
                  Portofolio
                </span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-700 font-medium">{{ portofolio.title }}</span>
              </nav>

              <!-- Title -->
              <div class="info-item">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4">
                  {{ portofolio.title }}
                </h1>
                <p class="text-gray-700 leading-relaxed text-base">
                  {{ portofolio.description || 'Werkudara (Bima) Illustration – A digital/hand-drawn artwork inspired by the legendary wayang character Werkudara, also known as Bima. Depicted with his strong physique and iconic attributes, this artwork highlights Bima\'s symbolism as a figure of strength, loyalty, and perseverance in Javanese culture.' }}
                </p>
              </div>

              <!-- Divider -->
              <div class="info-item border-t border-gray-300"></div>

              <!-- Tools -->
              <div class="info-item">
                <h2 class="text-lg font-bold text-gray-900 mb-2">Tools</h2>
                <p class="text-gray-800 text-base">
                  {{ portofolio.tools || 'Adobe Illustrator' }}
                </p>
              </div>

              <!-- Divider -->
              <div class="info-item border-t border-gray-300"></div>

              <!-- Category -->
              <div class="info-item">
                <h2 class="text-lg font-bold text-gray-900 mb-2">Category</h2>
                <div class="flex flex-wrap gap-2">
                  <span class="inline-block px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-medium text-sm">
                    {{ portofolio.category || 'Proyek Seni' }}
                  </span>
                </div>
              </div>

              <!-- Action Button -->
              <div class="info-item pt-2 flex justify-center">
                <a
                  :href="`https://wa.me/6281234567890?text=Hi, saya tertarik dengan portofolio ${portofolio.title}`"
                  target="_blank"
                  class="inline-flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 w-full"
                >
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                  </svg>
                  Contact via WhatsApp
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom scrollbar untuk modal */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

/* Smooth transitions */
* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Border width utility */
.border-3 {
  border-width: 3px;
}
</style>
