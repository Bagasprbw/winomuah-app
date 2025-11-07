<template>
    <AppLayout :company="company">
        <div class="bg-[#fffaf3] min-h-screen px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-1">
                <Link href="/admin/dashboard" class="hover:text-[#f9a825]">Dashboard</Link>
                <span>/</span>
                <Link href="/admin/portofolio" class="hover:text-[#f9a825]">Portofolio</Link>
                <span>/</span>
                <span class="text-[#f9a825] font-medium">Add New</span>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#f9a825]">Add New Portofolio</h1>
                <Link href="/admin/portofolio"
                    class="bg-[#e0e0e0] hover:bg-[#ccc] text-gray-800 font-medium px-4 py-2 rounded-lg">
                ← Back
                </Link>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitForm" class="bg-white p-8 rounded-2xl shadow-md max-w-3xl mx-auto">
                <!-- Portofolio Name -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portofolio title</label>
                    <input v-model="form.title" type="text" placeholder="Enter portofolio title"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                        required />
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea v-model="form.description" placeholder="Enter portofolio description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"></textarea>
                </div>

                <!-- Price & Category -->
                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tools</label>
                        <input v-model="form.tools" type="text" step="0.01" placeholder="Ex: Photoshop, Corel Draw"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>

                        <div class="flex space-x-2">
                            <select v-model="form.category_id"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                                required>
                                <option disabled value="">Select Category</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                    {{ cat.name }}
                                </option>
                            </select>

                            <button type="button" @click="showAddCategory = true"
                                class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-3 py-2 rounded-lg font-semibold">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portofolio Image</label>
                    <input type="file" @change="handleImageUpload" accept="image/*"
                        class="border border-dashed border-gray-400 w-full p-4 rounded-lg cursor-pointer hover:border-[#f9a825]" />
                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG up to 5MB</p>
                    <img v-if="preview" :src="preview" alt="Preview"
                        class="mt-3 w-32 h-32 object-cover rounded-lg border" />
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <Link href="/admin/portofolio"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold">
                    Cancel
                    </Link>
                    <button type="submit"
                        class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-5 py-2 rounded-lg font-semibold">
                        Save Portofolio
                    </button>
                </div>
            </form>

            <!-- Modal Add/Delete Category -->
            <transition name="fade">
                <div v-if="showAddCategory" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl p-6 w-[400px] shadow-lg relative">

                        <!-- Alert di dalam modal -->
                        <transition name="fade-shake">
                            <div v-if="alertMessage" :class="[
                                'mb-4 text-sm px-5 py-2 text-center rounded-lg font-medium shadow-sm',
                                alertType === 'success'
                                    ? 'bg-[#fff3e0] border border-[#fbc02d] text-[#795548]'
                                    : 'bg-red-100 border border-red-300 text-red-700'
                            ]">
                                <i :class="[
                                    'fa-solid mr-2',
                                    alertType === 'success' ? 'fa-circle-check text-[#f9a825]' : 'fa-circle-xmark text-red-500'
                                ]"></i>
                                {{ alertMessage }}
                            </div>
                        </transition>



                        <h2 class="text-lg font-bold text-[#f9a825] mb-4 mt-8">
                            Manage Categories
                        </h2>

                        <!-- Input Tambah -->
                        <div class="flex mb-4 space-x-2">
                            <input v-model="newCategory" type="text" placeholder="Category name"
                                @keyup.enter="addCategory"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825]" />
                            <button @click="addCategory"
                                class="bg-[#f9a825] text-white px-4 py-2 rounded-lg hover:bg-[#fbc02d] font-semibold">
                                Save
                            </button>
                        </div>

                        <!-- Daftar kategori -->
                        <ul class="space-y-2 max-h-60 overflow-y-auto border-t pt-2">
                            <li v-for="cat in categories" :key="cat.id" class="flex justify-between items-center">
                                <span>{{ cat.name }}</span>
                                <button @click="confirmDelete(cat)"
                                    class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                            </li>
                        </ul>

                        <div class="flex justify-end mt-5">
                            <button @click="showAddCategory = false"
                                class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">Close</button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '../AppLayout.vue'

const props = defineProps({
    company: Object,
    categories: Array,
})

const form = ref({
    name: '',
    description: '',
    price: '',
    category_id: '',
    image: null,
})

const preview = ref(null)
const showAddCategory = ref(false)
const newCategory = ref('')
const alertMessage = ref(null)
const alertType = ref('success')

function showAlert(message, type = 'success') {
    alertMessage.value = message
    alertType.value = type
    setTimeout(() => {
        alertMessage.value = null
    }, 3000)
}

function handleImageUpload(e) {
    const file = e.target.files[0]
    if (file) {
        form.value.image = file
        preview.value = URL.createObjectURL(file)
    }
}

// tambah kategori baru
function addCategory() {
    if (!newCategory.value.trim()) return

    router.post(
        '/admin/categories',
        { name: newCategory.value, type: 'portofolio' },
        {
            onSuccess: () => {
                showAlert('✅ Category added successfully!', 'success')
                newCategory.value = ''
                router.reload({ only: ['categories'] })
            },
            onError: () => {
                showAlert('❌ Failed to add category.', 'error')
            },
        }
    )
}

// hapus kategori
function confirmDelete(cat) {
    if (
        !confirm(
            `⚠️ Category "${cat.name}" may contain portofolios.\nDeleting this category will also remove related portofolios and their images.\n\nDo you want to continue?`
        )
    ) {
        return
    }

    router.delete(`/admin/categories/${cat.id}`, {
        onSuccess: () => {
            showAlert('🗑️ Category deleted successfully!', 'success')
            router.reload({ only: ['categories'] })
        },
        onError: () => {
            showAlert('❌ Failed to delete category.', 'error')
        },
    })
}

// submit produk baru
function submitForm() {
    const data = new FormData()
    data.append('title', form.value.title)
    data.append('description', form.value.description)
    data.append('tools', form.value.tools)
    data.append('category_id', form.value.category_id)
    if (form.value.image) data.append('image', form.value.image)

    router.post('/admin/portofolio', data, {
        forceFormData: true,
        onSuccess: () => {
            router.visit('/admin/portofolio')
        },
    })
}
</script>

<style scoped>
.fade-shake-enter-active,
.fade-shake-leave-active {
    transition: all 0.4s ease;
}

.fade-shake-enter-from,
.fade-shake-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* efek goyang */
@keyframes shake {
    0% {
        transform: translateX(0);
    }

    25% {
        transform: translateX(-5px);
    }

    50% {
        transform: translateX(5px);
    }

    75% {
        transform: translateX(-3px);
    }

    100% {
        transform: translateX(0);
    }
}

.fade-shake-enter-active {
    animation: shake 0.4s ease-in-out;
}
</style>
