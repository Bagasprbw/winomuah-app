<template>
  <Transition
    enter-active-class="transition-opacity duration-300"
    enter-from-class="opacity-0"
    leave-active-class="transition-opacity duration-300"
    leave-to-class="opacity-0"
  >
    <div
      v-if="product"
      class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 px-4"
      @click.self="$emit('close')"
    >
      <div
        class="bg-white rounded-2xl w-full max-w-5xl shadow-2xl overflow-hidden animate-fadeInUp"
        @click.stop
      >
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
          <h2 class="text-3xl font-extrabold text-[#f9a825] tracking-tight">
            {{ title }}
          </h2>
          <button
            @click="$emit('close')"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-700"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Content -->
        <div class="grid md:grid-cols-2 gap-8 p-8 max-h-[85vh] overflow-y-auto">
          <!-- Left: Image -->
          <div class="space-y-4">
            <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-100">
              <img
                :src="mainImage"
                :alt="title"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
              />
            </div>

            <div v-if="images.length" class="grid grid-cols-3 gap-3">
              <div
                v-for="(img, idx) in images"
                :key="idx"
                class="aspect-square rounded-lg overflow-hidden bg-gray-100 border border-transparent hover:border-[#f9a825] transition"
              >
                <img
                  :src="resolveImage(img)"
                  :alt="`${title} ${idx + 1}`"
                  class="w-full h-full object-cover"
                />
              </div>
            </div>
          </div>

          <!-- Right: Details -->
          <div class="space-y-6">
            <!-- Price -->
            <div>
              <h3 class="text-sm font-semibold text-[#f9a825] uppercase mb-1 tracking-wide">Price</h3>
              <p class="text-3xl font-extrabold text-[#f9a825]">{{ formattedPrice }}</p>
            </div>

            <!-- Description -->
            <div>
              <h3 class="text-sm font-semibold text-[#f9a825] uppercase mb-1 tracking-wide">Description</h3>
              <p class="text-[#333] leading-relaxed whitespace-pre-line">{{ desc }}</p>
            </div>

            <!-- Material -->
            <div v-if="material">
              <h3 class="text-sm font-semibold text-[#f9a825] uppercase mb-1 tracking-wide">Material</h3>
              <p class="text-[#333]">{{ material }}</p>
            </div>

            <!-- Category -->
            <div v-if="category">
              <h3 class="text-sm font-semibold text-[#f9a825] uppercase mb-1 tracking-wide">Category</h3>
              <span class="inline-block px-4 py-1.5 bg-[#fff7e0] text-[#333] rounded-full text-sm font-medium shadow-sm">
                {{ category }}
              </span>
            </div>

            <!-- WhatsApp Order Button -->
            <div class="pt-4">
              <a
                :href="whatsappLink"
                target="_blank"
                class="block w-full text-center bg-[#f9a825] hover:bg-[#fbc02d] text-white font-semibold py-3 rounded-xl shadow-md transition"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M16.7 14.3c-.3-.2-1.8-.9-2.1-1s-.5-.2-.7.2-.8 1-.9 1.1-.3.2-.6.1c-.3-.2-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1s0-.5.1-.6l.5-.6c.2-.2.2-.3.3-.5s0-.4 0-.5c0-.2-.7-1.6-.9-2.2s-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.4 1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3 1.8.8 2.5.9 3.4.8.6-.1 1.1-.5 1.2-.9.1-.4.1-.7.1-.8s-.1-.1-.3-.2z" />
                </svg>
                Order via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  product: {
    type: Object,
    default: null
  }
})
defineEmits(['close'])

const title = computed(() => props.product?.title ?? props.product?.name ?? 'Untitled')
const desc = computed(() => props.product?.desc ?? props.product?.description ?? '')
const material = computed(() => props.product?.material ?? props.product?.materials ?? '')
const category = computed(() => {
  if (!props.product) return null
  if (typeof props.product.category === 'string') return props.product.category
  if (props.product.category?.name) return props.product.category.name
  return null
})
const images = computed(() => Array.isArray(props.product?.images) ? props.product.images : [])
function resolveImage(path) {
  if (!path) return '/assets/placeholder.png'
  if (path.startsWith('http') || path.startsWith('/')) return path
  return `/storage/${path}`
}
const mainImage = computed(() => {
  if (!props.product) return '/assets/placeholder.png'
  return resolveImage(props.product.image ?? images.value[0])
})

const formattedPrice = computed(() => {
  const p = Number(props.product?.price ?? 0)
  return `Rp ${p.toLocaleString('id-ID')}`
})


// Ganti dengan nomor WA kamu
const whatsappNumber = '6281234567890'
const whatsappLink = computed(() => {
  const text = encodeURIComponent(`Halo, saya tertarik dengan produk "${title.value}" seharga ${formattedPrice.value}`)
  return `https://wa.me/${whatsappNumber}?text=${text}`
})
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeInUp {
  animation: fadeInUp 0.35s ease-out;
}
</style>
