<template>
    <AppLayout :company="company">
        <div class="bg-[#fffaf3] min-h-screen px-4 sm:px-6 py-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#f9a825]">Products</h1>

                <Link
                    href="/admin/products/create"
                    class="bg-[#f9a825] hover:bg-[#fbc02d] text-white font-semibold px-5 py-2 rounded-lg transition text-center"
                >
                    TAMBAH PRODUK
                </Link>
            </div>

            <!-- Table Wrapper for Horizontal Scroll -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden mt-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead class="bg-[#fff3e0] text-gray-700 uppercase text-sm">
                            <tr>
                                <th class="px-4 py-3 border-b">Gambar Produk</th>
                                <th class="px-4 py-3 border-b">Nama Produk</th>
                                <th class="px-4 py-3 border-b">Deskripsi</th>
                                <th class="px-4 py-3 border-b">Harga</th>
                                <th class="px-4 py-3 border-b">Kategori</th>
                                <th class="px-4 py-3 border-b">Status</th>
                                <th class="px-4 py-3 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="product in products"
                                :key="product.id"
                                class="hover:bg-[#fff8e1] transition"
                            >
                                <!-- Gambar -->
                                <td class="px-4 py-3 border-b">
                                    <img
                                        v-if="product.image"
                                        :src="`/storage/${product.image}`"
                                        alt="Produk"
                                        class="w-16 h-16 rounded-md object-cover"
                                    />
                                    <div
                                        v-else
                                        class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-xs"
                                    >
                                        No Image
                                    </div>
                                </td>

                                <!-- Nama -->
                                <td class="px-4 py-3 border-b font-semibold text-gray-800">
                                    {{ product.name }}
                                </td>

                                <!-- Deskripsi -->
                                <td class="px-4 py-3 border-b text-gray-600 text-sm max-w-[250px] truncate">
                                    {{ product.description }}
                                </td>

                                <!-- Harga -->
                                <td class="px-4 py-3 border-b text-gray-700">
                                    Rp {{ Number(product.price).toLocaleString('id-ID') }}
                                </td>

                                <!-- Kategori -->
                                <td class="px-4 py-3 border-b text-gray-700">
                                    {{ product.category || '-' }}
                                </td>

                                <!-- Status Publish (Dropdown) -->
                                <td class="px-4 py-3 border-b text-gray-700">
                                    <select
                                        v-model="product.is_published"
                                        @change="updatePublishStatus(product)"
                                        class="border rounded-full px-3 py-1 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#f9a825]"
                                    >
                                        <option :value="true">Published</option>
                                        <option :value="false">Private</option>
                                    </select>
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 py-3 border-b">
                                    <div class="flex flex-col space-y-2 min-w-[120px]">
                                        <!-- Tombol Detail -->
                                        <Link
                                            :href="`/admin/products/${product.id}`"
                                            class="bg-[#4e342e] hover:bg-[#3e2723] text-white px-4 py-1 rounded-full text-sm font-semibold text-center"
                                        >
                                            DETAIL
                                        </Link>

                                        <!-- Tombol Edit -->
                                        <Link
                                            :href="`/admin/products/${product.id}/edit`"
                                            class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-4 py-1 rounded-full text-sm font-semibold text-center"
                                        >
                                            EDIT
                                        </Link>

                                        <!-- Tombol Hapus -->
                                        <button
                                            @click="confirmDelete(product)"
                                            class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white px-4 py-1 rounded-full text-sm font-semibold"
                                        >
                                            HAPUS
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { defineProps } from 'vue'
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
    products: Array,
    company: Object,
})

function updatePublishStatus(product) {
    router.patch(`/admin/products/${product.id}/publish`, { is_published: product.is_published }, {
        preserveScroll: true,
        preserveState: true,
    })
}

function confirmDelete(product) {
    if (confirm(`Apakah kamu yakin ingin menghapus produk "${product.name}"?`)) {
        router.delete(`/admin/products/${product.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ['products'] })
            },
        })
    }
}
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border-color: #e0e0e0;
}
</style>
