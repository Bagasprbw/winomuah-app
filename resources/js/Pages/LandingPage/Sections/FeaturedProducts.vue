<template>
  <section class="py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
        Featured Products
      </h2>

      <div
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

      <div class="flex justify-center mt-12">
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
import { Link } from '@inertiajs/vue3';
import ProductCard from "@/Components/ProductCard.vue";
defineProps({ products: Array });
</script>
