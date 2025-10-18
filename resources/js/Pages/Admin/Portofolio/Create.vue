<template>
    <AppLayout :company="company">
        <div class="bg-[#fffaf3] min-h-screen px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-1">
                <Link href="/admin/dashboard" class="hover:text-[#f9a825]">Dashboard</Link>
                <span>/</span>
                <Link href="/admin/products" class="hover:text-[#f9a825]">Products</Link>
                <span>/</span>
                <span class="text-[#f9a825] font-medium">Add New</span>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#f9a825]">Add New Product</h1>
                <Link href="/admin/products"
                    class="bg-[#e0e0e0] hover:bg-[#ccc] text-gray-800 font-medium px-4 py-2 rounded-lg">
                ← Back
                </Link>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitForm" class="bg-white p-8 rounded-2xl shadow-md max-w-3xl mx-auto">
                <!-- Product Name -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                    <input v-model="form.name" type="text" placeholder="Enter product title"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
                        required />
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea v-model="form.description" placeholder="Enter product description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"></textarea>
                </div>

                <!-- Price & Category -->
                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price</label>
                        <input v-model="form.price" type="number" step="0.01" placeholder="Rp 0"
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                    <input type="file" @change="handleImageUpload" accept="image/*"
                        class="border border-dashed border-gray-400 w-full p-4 rounded-lg cursor-pointer hover:border-[#f9a825]" />
                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG up to 5MB</p>
                    <img v-if="preview" :src="preview" alt="Preview"
                        class="mt-3 w-32 h-32 object-cover rounded-lg border" />
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <Link href="/admin/products"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold">
                    Cancel
                    </Link>
                    <button type="submit"
                        class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-5 py-2 rounded-lg font-semibold">
                        Save Product
                    </button>
                </div>
            </form>

            <!-- Modal Add Category -->
            <transition name="fade">
                <div v-if="showAddCategory" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl p-6 w-[350px] shadow-lg">
                        <h2 class="text-lg font-bold text-[#f9a825] mb-4">
                            Add New Category
                        </h2>
                        <input v-model="newCategory" type="text" placeholder="Category name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-[#f9a825]" />
                        <div class="flex justify-end space-x-2">
                            <button @click="showAddCategory = false"
                                class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">
                                Cancel
                            </button>
                            <button @click="addCategory"
                                class="bg-[#f9a825] text-white px-4 py-1 rounded-lg hover:bg-[#fbc02d]">
                                Save
                            </button>
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
        { name: newCategory.value, type: 'product' },
        {
            onSuccess: () => {
                showAddCategory.value = false
                newCategory.value = ''
                router.reload({ only: ['categories'] })
            },
        }
    )
}

// submit produk baru
function submitForm() {
    const data = new FormData()
    data.append('name', form.value.name)
    data.append('description', form.value.description)
    data.append('price', form.value.price)
    data.append('category_id', form.value.category_id)
    if (form.value.image) data.append('image', form.value.image)

    router.post('/admin/products', data, {
        forceFormData: true,
        onSuccess: () => {
            router.visit('/admin/products')
        },
    })
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
