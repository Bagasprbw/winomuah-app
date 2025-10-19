<template>
    <AppLayout :company="company">
        <div class="bg-[#fffaf3] min-h-screen px-6 py-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#f9a825]">Portofolio</h1>

                <Link href="/admin/portofolio/create"
                    class="bg-[#f9a825] hover:bg-[#fbc02d] text-white font-semibold px-5 py-2 rounded-lg transition">
                TAMBAH Portofolio
                </Link>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden mt-4">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#fff3e0] text-gray-700 uppercase text-sm">
                        <tr>
                            <th class="px-4 py-3 border-b">Gambar</th>
                            <th class="px-4 py-3 border-b">Judul</th>
                            <th class="px-4 py-3 border-b">Deskripsi</th>
                            <th class="px-4 py-3 border-b">Tools</th>
                            <th class="px-4 py-3 border-b">Kategori</th>
                            <th class="px-4 py-3 border-b">Status</th>
                            <th class="px-4 py-3 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="portofolio in portofolio" :key="portofolio.id" class="hover:bg-[#fff8e1] transition">
                            <!-- Gambar -->
                            <td class="px-4 py-3 border-b">
                                <img v-if="portofolio.image" :src="`/storage/${portofolio.image}`" alt="Portofolio"
                                    class="w-16 h-16 rounded-md object-cover" />
                                <div v-else
                                    class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-xs">
                                    No Image
                                </div>
                            </td>

                            <!-- Nama -->
                            <td class="px-4 py-3 border-b font-semibold text-gray-800">
                                {{ portofolio.title }}
                            </td>

                            <!-- Deskripsi -->
                            <td class="px-4 py-3 border-b text-gray-600 text-sm max-w-[250px] truncate">
                                {{ portofolio.description }}
                            </td>

                            <!-- Harga -->
                            <td class="px-4 py-3 border-b text-gray-700">
                                {{ portofolio.tools }}
                            </td>

                            <!-- Kategori -->
                            <td class="px-4 py-3 border-b text-gray-700">
                                {{ portofolio.category || '-' }}
                            </td>

                            <!-- Status Publish (Dropdown) -->
                            <td class="px-4 py-3 border-b text-gray-700">
                                <select v-model="portofolio.is_published" @change="updatePublishStatus(portofolio)"
                                    class="border rounded-full px-3 py-1 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#f9a825]">
                                    <option :value="true">Published</option>
                                    <option :value="false">Private</option>
                                </select>
                            </td>

                            <!-- Aksi -->

                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col space-y-2">
                                    <!-- Tombol Tampilkan -->
                                    <button
                                        class="bg-[#4e342e] hover:bg-[#3e2723] text-white px-4 py-1 rounded-full text-sm font-semibold">
                                        TAMPILKAN
                                    </button>

                                    <!-- Tombol Edit -->
                                    <Link :href="`/admin/portofolio/${portofolio.id}/edit`"
                                        class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-4 py-1 rounded-full text-sm font-semibold text-center">
                                    EDIT
                                    </Link>

                                    <!-- Tombol Hapus -->
                                    <button @click="confirmDelete(portofolio)"
                                        class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white px-4 py-1 rounded-full text-sm font-semibold">
                                        HAPUS
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { defineProps } from 'vue'
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
    portofolio: Array,
    company: Object,
})

/**
 * Update status publish di backend
 */
function updatePublishStatus(portofolio) {
    router.patch(
        `/admin/portofolio/${portofolio.id}/publish`,
        { is_published: portofolio.is_published },
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}

function confirmDelete(portofolio) {
    if (confirm(`Apakah kamu yakin ingin menghapus portofolio "${portofolio.name}"?`)) {
        router.delete(`/admin/portofolio/${portofolio.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // opsional: bisa reload halaman agar daftar portofolio terbaru
                router.reload({ only: ['portofolio'] })
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
