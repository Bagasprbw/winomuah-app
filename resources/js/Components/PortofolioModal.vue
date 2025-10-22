<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Props
const props = defineProps({
  portofolio: Object
});

// Emits
const emit = defineEmits(['close']);

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
  selectedImage.value = imageUrl;
};

// Function untuk close modal
const closeModal = () => {
  emit('close');
};

// Function untuk handle ESC key
const handleEscape = (e) => {
  if (e.key === 'Escape') {
    closeModal();
  }
};

// Lifecycle hooks
onMounted(() => {
  document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
});
</script>

<template>
  <Transition name="fade-scale">
    <div
      class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto"
      @click.self="closeModal"
    >
      <!-- Modal Container -->
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-y-auto my-8">
        <!-- Close Button -->
        <button
          @click="closeModal"
          class="absolute top-4 right-4 z-10 w-10 h-10 bg-white hover:bg-gray-100 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 group"
          aria-label="Close modal"
        >
          <svg class="w-5 h-5 text-gray-600 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Modal Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-10">
          <!-- Left Side - Images -->
          <div class="space-y-4">
            <!-- Main Image -->
            <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 shadow-md">
              <TransitionGroup name="image-fade" mode="out-in">
                <img
                  v-if="selectedImage"
                  :key="selectedImage"
                  :src="selectedImage"
                  :alt="portofolio.title"
                  class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                  <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </TransitionGroup>
            </div>

            <!-- Thumbnail Images -->
            <div v-if="thumbnails.length > 0" class="grid grid-cols-3 gap-3">
              <button
                v-for="(thumb, index) in thumbnails"
                :key="index"
                @click="selectImage(thumb)"
                class="aspect-[4/3] rounded-xl overflow-hidden border-2 transition-all duration-300 hover:scale-105"
                :class="selectedImage === thumb ? 'border-amber-500 shadow-md' : 'border-gray-200 hover:border-amber-300'"
              >
                <img
                  :src="thumb"
                  :alt="`${portofolio.title} thumbnail ${index + 1}`"
                  class="w-full h-full object-cover"
                />
              </button>
            </div>
          </div>

          <!-- Right Side - Portofolio Info -->
          <div class="space-y-6">
            <!-- Portofolio Title -->
            <div>
              <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 leading-tight">
                {{ portofolio.title }}
              </h1>

              <!-- Portofolio Description -->
              <p class="text-gray-600 leading-relaxed text-base">
                {{ portofolio.description || 'No description available for this portofolio.' }}
              </p>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Year Section -->
            <div class="space-y-2">
              <h2 class="text-xl font-bold text-gray-900">Tahun</h2>
              <p class="text-2xl font-semibold text-gray-800">
                {{ portofolio.year || '-' }}
              </p>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Tools Section -->
            <div class="space-y-2">
              <h2 class="text-xl font-bold text-gray-900">Tools</h2>
              <p class="text-gray-700 text-lg">
                {{ portofolio.tools || '-' }}
              </p>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Category Section -->
            <div class="space-y-2">
              <h2 class="text-xl font-bold text-gray-900">Category</h2>
              <span class="inline-block px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-medium text-sm">
                {{ portofolio.category || 'Uncategorized' }}
              </span>
            </div>

            <!-- Action Button -->
            <div class="pt-4">
              <a
                :href="`https://wa.me/6281234567890?text=Hi, saya tertarik dengan portofolio ${portofolio.title}`"
                target="_blank"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
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
  </Transition>
</template>

<style scoped>
/* Modal fade-scale transition */
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* Image fade transition */
.image-fade-enter-active,
.image-fade-leave-active {
  transition: opacity 0.3s ease;
}

.image-fade-enter-from,
.image-fade-leave-to {
  opacity: 0;
}

/* Custom scrollbar untuk modal */
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}
</style>
