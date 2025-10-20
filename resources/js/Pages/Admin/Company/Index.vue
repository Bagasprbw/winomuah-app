<template>
    <AppLayout :company="company">
        <div class="bg-[#fffaf3] min-h-screen px-6 py-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-[#f9a825]">Edit Company</h1>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-md p-8 max-w-4xl mx-auto">
                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Company Name -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Company Name</label>
                        <input v-model="form.company_name" type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                            placeholder="Masukkan nama perusahaan" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Phone</label>
                        <input v-model="form.phone" type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                            placeholder="Masukkan nomor telepon" />
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                        <input v-model="form.address" type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                            placeholder="Masukkan alamat perusahaan" />
                    </div>

                    <!-- About -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tentang Perusahaan</label>
                        <textarea v-model="form.about" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                            placeholder="Deskripsikan perusahaan Anda..."></textarea>
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Instagram</label>
                        <input v-model="form.instagram" type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                            placeholder="@username" />
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Logo</label>
                        <input type="file" @change="handleFileChange($event, 'logo')" accept=".jpg,.jpeg,.png"
                            class="w-full border border-dashed border-gray-300 rounded-lg px-4 py-3 text-gray-600 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#f9a825]" />
                        <p class="text-sm text-gray-500 mt-1">⚠️ Maksimal ukuran gambar 9 MB (.jpg, .jpeg, .png)</p>

                        <div v-if="company.logo" class="mt-4">
                            <p class="text-gray-500 text-sm mb-2">Gambar saat ini:</p>
                            <div class="border border-gray-200 bg-gray-50 rounded-lg p-2 inline-block mb-2">
                                <img :src="`/storage/${company.logo}`" alt="Logo"
                                    class="h-20 object-contain rounded-lg" />
                            </div>
                        </div>
                    </div>

                    <!-- Banner Upload -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Banner</label>
                        <input type="file" @change="handleFileChange($event, 'banner')" accept=".jpg,.jpeg,.png"
                            class="w-full border border-dashed border-gray-300 rounded-lg px-4 py-3 text-gray-600 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#f9a825]" />
                        <p class="text-sm text-gray-500 mt-1">⚠️ Maksimal ukuran gambar 9 MB (.jpg, .jpeg, .png)</p>

                        <div v-if="company.banner" class="mt-4">
                            <p class="text-gray-500 text-sm mb-2">Gambar saat ini:</p>
                            <div class="border border-gray-200 bg-gray-50 rounded-lg p-2 overflow-hidden">
                                <img :src="`/storage/${company.banner}`" alt="Banner"
                                    class="w-full max-h-64 object-contain rounded-lg" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-[#f9a825] hover:bg-[#fbc02d] text-white font-semibold px-8 py-2.5 rounded-lg transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
    company: Object,
})

const form = useForm({
    company_name: props.company.company_name || '',
    phone: props.company.phone || '',
    address: props.company.address || '',
    about: props.company.about || '',
    instagram: props.company.instagram || '',
    logo: null,
    banner: null,
})

// Maksimal 9 MB
const MAX_FILE_SIZE = 9 * 1024 * 1024

function handleFileChange(event, field) {
    const file = event.target.files[0]
    if (file && file.size > MAX_FILE_SIZE) {
        alert('Ukuran file maksimal 9 MB!')
        event.target.value = '' // reset input
        return
    }
    form[field] = file
}

function submit() {
    form.post('/admin/company/update', {
        preserveScroll: true,
        forceFormData: true,
    })
}
</script>

<style scoped>
input[type="file"] {
    background: #fff;
    transition: all 0.2s ease;
}
input[type="file"]:hover {
    background: #fffdf6;
}
</style>
