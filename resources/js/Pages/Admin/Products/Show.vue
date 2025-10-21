<template>
  <AppLayout :company="company">
    <div class="bg-[#fffaf3] min-h-screen px-8 py-8">
      <!-- Breadcrumb -->
      <div class="flex items-center text-sm text-gray-500 mb-4 space-x-1">
        <Link href="/admin/dashboard" class="hover:text-[#f9a825]">Dashboard</Link>
        <span>/</span>
        <Link href="/admin/products" class="hover:text-[#f9a825]">Produk</Link>
        <span>/</span>
        <span class="text-[#f9a825] font-medium">{{ product.name }}</span>
      </div>

      <!-- Header -->
      <h1 class="text-3xl font-bold text-[#f9a825] mb-6">Detail Produk</h1>

      <!-- Card -->
      <div
        class="bg-white p-8 rounded-2xl shadow-md max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8"
      >
        <!-- Gambar Produk -->
        <div class="flex justify-center items-center">
          <img
            v-if="product.image"
            :src="`/storage/${product.image}`"
            alt="Product Image"
            class="w-full max-w-sm rounded-xl border object-cover shadow"
          />
          <div
            v-else
            class="w-full max-w-sm h-64 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400"
          >
            No Image
          </div>
        </div>

        <!-- Detail Produk -->
        <div>
          <h2 class="text-2xl font-bold text-gray-800">{{ product.name }}</h2>
          <p class="text-sm text-gray-500 mt-1">
            Ditambahkan pada {{ formatDate(product.created_at) }}
          </p>

          <!-- Info dengan garis -->
          <div class="mt-5 border-t border-[#f9a825]/30 pt-4 space-y-4 text-gray-700">
            <div class="pb-3 border-b border-gray-200">
              <span class="font-semibold text-[#f9a825]">Deskripsi:</span>
              <p class="text-sm mt-1 leading-relaxed">
                {{ product.description || '-' }}
              </p>
            </div>

            <div class="pb-3 border-b border-gray-200">
              <span class="font-semibold text-[#f9a825]">Harga:</span>
              <p class="text-sm mt-1">
                Rp {{ Number(product.price).toLocaleString('id-ID') }}
              </p>
            </div>

            <div class="pb-3 border-b border-gray-200">
              <span class="font-semibold text-[#f9a825]">Kategori:</span>
              <p class="text-sm mt-1">{{ product.category?.name || '-' }}</p>
            </div>

            <div class="pb-1">
              <span class="font-semibold text-[#f9a825]">Status:</span>
              <span
                class="ml-2 inline-block px-3 py-1 rounded-full text-xs font-semibold"
                :class="product.is_published ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'"
              >
                {{ product.is_published ? 'Published' : 'Private' }}
              </span>
            </div>
          </div>

          <!-- Tombol -->
          <div class="mt-8 flex space-x-3">
            <Link
              href="/admin/products"
              class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold"
            >
              Kembali
            </Link>
            <Link
              :href="`/admin/products/${product.id}/edit`"
              class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-5 py-2 rounded-lg font-semibold"
            >
              Edit
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '../AppLayout.vue'

const props = defineProps({
  company: Object,
  product: Object,
})

function formatDate(date) {
  if (!date) return '-'
  const d = new Date(date)
  return d.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}
</script>

<style scoped>
img {
  transition: transform 0.3s ease;
}
img:hover {
  transform: scale(1.03);
}
button, a {
  transition: all 0.2s ease;
}
</style>
