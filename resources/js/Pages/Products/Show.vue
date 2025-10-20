<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../AppLayout.vue';

// Props dari Laravel Controller
const props = defineProps({
  product: Object
});

// State untuk gambar yang dipilih
const selectedImage = ref(props.product.image);

// Array thumbnail images (main image + duplicates untuk demo)
const thumbnails = [
  props.product.image,
  props.product.image,
  props.product.image
].filter(Boolean);

// Function untuk ganti gambar utama
const selectImage = (imageUrl) => {
  selectedImage.value = imageUrl;
};
</script>

<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-amber-50 to-white min-h-screen">
      <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm mb-8">
          <Link
            href="/products"
            class="text-amber-500 hover:text-amber-600 font-medium transition-colors"
          >
            Products
          </Link>
          <span class="text-gray-400">/</span>
          <span class="text-gray-700 font-medium">{{ product.name }}</span>
        </nav>

        <!-- Product Detail Container -->
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-10">
            <!-- Left Side - Images -->
            <div class="space-y-4">
              <!-- Main Image -->
              <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-md">
                <TransitionGroup name="image-fade" mode="out-in">
                  <img
                    v-if="selectedImage"
                    :key="selectedImage"
                    :src="selectedImage"
                    :alt="product.name"
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
                  class="aspect-square rounded-xl overflow-hidden border-2 transition-all duration-300 hover:scale-105"
                  :class="selectedImage === thumb ? 'border-amber-500 shadow-md' : 'border-gray-200 hover:border-amber-300'"
                >
                  <img
                    :src="thumb"
                    :alt="`${product.name} thumbnail ${index + 1}`"
                    class="w-full h-full object-cover"
                  />
                </button>
              </div>
            </div>

            <!-- Right Side - Product Info -->
            <div class="space-y-6">
              <!-- Product Name -->
              <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 leading-tight">
                  {{ product.name }}
                </h1>

                <!-- Product Description -->
                <p class="text-gray-600 leading-relaxed text-base">
                  {{ product.description || 'No description available for this product.' }}
                </p>
              </div>

              <!-- Divider -->
              <div class="border-t border-gray-200"></div>

              <!-- Price Section -->
              <div class="space-y-2">
                <h2 class="text-xl font-bold text-gray-900">Price</h2>
                <p class="text-3xl font-bold text-amber-600">
                  {{ product.price }}
                </p>
              </div>

              <!-- Divider -->
              <div class="border-t border-gray-200"></div>

              <!-- Material/Bahan Section -->
              <div class="space-y-2">
                <h2 class="text-xl font-bold text-gray-900">Bahan</h2>
                <p class="text-gray-700 text-lg">
                  {{ product.category || '-' }}
                </p>
              </div>

              <!-- Divider -->
              <div class="border-t border-gray-200"></div>

              <!-- Category Section -->
              <div class="space-y-2">
                <h2 class="text-xl font-bold text-gray-900">Category</h2>
                <span class="inline-block px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-medium text-sm">
                  {{ product.category || 'Uncategorized' }}
                </span>
              </div>

              <!-- Action Buttons -->
              <div class="pt-4 space-y-3">
                <a
                  :href="`https://wa.me/6281234567890?text=Hi, saya tertarik dengan produk ${product.name}`"
                  target="_blank"
                  class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                >
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                  </svg>
                  Order via WhatsApp
                </a>

                <Link
                  href="/products"
                  class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-6 rounded-xl flex items-center justify-center gap-2 transition-all duration-300"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                  Back to Products
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Related Products Section (Optional - can be added later) -->
        <div class="mt-16">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">You may also like</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Placeholder untuk related products -->
            <div class="text-center text-gray-400 col-span-full py-8">
              Ini Nanti Opsional 
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- WhatsApp FAB -->
    <a
      :href="`https://wa.me/6281234567890?text=Hi, saya tertarik dengan produk ${product.name}`"
      target="_blank"
      class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110 z-50"
    >
      <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
      </svg>
    </a>
  </MainLayout>
</template>

<style scoped>
/* Image transition animations */
.image-fade-enter-active,
.image-fade-leave-active {
  transition: opacity 0.3s ease;
}

.image-fade-enter-from,
.image-fade-leave-to {
  opacity: 0;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}
</style>
