<template>
  <AppLayout :company="company">
    <div class="bg-[#fffaf3] min-h-screen px-8 py-8">
      <!-- Breadcrumb -->
      <div class="flex items-center text-sm text-gray-500 mb-4 space-x-1">
        <Link href="/admin/dashboard" class="hover:text-[#f9a825]">Dashboard</Link>
        <span>/</span>
        <Link href="/admin/portofolio" class="hover:text-[#f9a825]">Portofolio</Link>
        <span>/</span>
        <span class="text-[#f9a825] font-medium">Edit</span>
      </div>

      <!-- Header -->
      <h1 class="text-3xl font-bold text-[#f9a825] mb-6">Edit Portofolio</h1>

      <!-- Form -->
      <form @submit.prevent="updatePortofolio" class="bg-white p-8 rounded-2xl shadow-md max-w-3xl mx-auto">
        <!-- Portofolio Title -->
        <div class="mb-5">
          <label class="block font-semibold text-gray-700 mb-2">Portofolio Tile</label>
          <input v-model="form.title" type="text" class="input" required />
        </div>

        <!-- Description -->
        <div class="mb-5">
          <label class="block font-semibold text-gray-700 mb-2">Description</label>
          <textarea v-model="form.description" class="input" rows="3"></textarea>
        </div>

        <!-- Price & Category -->
        <div class="grid grid-cols-2 gap-6 mb-5">
          <div>
            <label class="block font-semibold text-gray-700 mb-2">Tools</label>
            <input v-model="form.tools" type="text" class="input" />
          </div>

          <div>
            <label class="block font-semibold text-gray-700 mb-2">Category</label>
            <div class="flex space-x-2">
              <select v-model="form.category_id" class="input flex-1" required>
                <option disabled value="">Select Category</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>

              <button
                type="button"
                @click="showAddCategory = true"
                class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-3 py-2 rounded-lg font-semibold"
              >
                +
              </button>
            </div>
          </div>
        </div>

        <!-- Image -->
        <div class="mb-6">
          <label class="block font-semibold text-gray-700 mb-2">Image</label>
          <input type="file" @change="handleImage" accept="image/*" class="input border-dashed" />
          <div class="mt-3 flex items-center space-x-3">
            <img
              v-if="preview"
              :src="preview"
              class="w-24 h-24 object-cover rounded-lg border"
            />
            <img
              v-else-if="portofolio.image"
              :src="`/storage/${portofolio.image}`"
              class="w-24 h-24 object-cover rounded-lg border"
            />
          </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-3">
          <Link
            href="/admin/portofolio"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold"
          >
            Cancel
          </Link>
          <button
            type="submit"
            class="bg-[#f9a825] hover:bg-[#fbc02d] text-white px-5 py-2 rounded-lg font-semibold"
          >
            Update Portofolio
          </button>
        </div>
      </form>

      <!-- Modal Add Category -->
      <transition name="fade">
        <div
          v-if="showAddCategory"
          class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
        >
          <div class="bg-white rounded-xl p-6 w-[350px] shadow-lg">
            <h2 class="text-lg font-bold text-[#f9a825] mb-4">
              Add New Category
            </h2>
            <input
              v-model="newCategory"
              type="text"
              placeholder="Category name"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-[#f9a825]"
            />
            <div class="flex justify-end space-x-2">
              <button
                @click="showAddCategory = false"
                class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300"
              >
                Cancel
              </button>
              <button
                @click="addCategory"
                class="bg-[#f9a825] text-white px-4 py-1 rounded-lg hover:bg-[#fbc02d]"
              >
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
  portofolio: Object,
})

// Form data
const form = ref({
  title: props.portofolio.title,
  description: props.portofolio.description,
  tools: props.portofolio.tools,
  category_id: props.portofolio.category_id,
  image: null,
})

const preview = ref(null)
const showAddCategory = ref(false)
const newCategory = ref('')

// Handle upload image
function handleImage(e) {
  const file = e.target.files[0]
  if (file) {
    form.value.image = file
    preview.value = URL.createObjectURL(file)
  }
}

// Add category
function addCategory() {
  if (!newCategory.value.trim()) return

  router.post(
    '/admin/categories',
    { name: newCategory.value, type: 'portofolio' },
    {
      onSuccess: () => {
        showAddCategory.value = false
        newCategory.value = ''
        router.reload({ only: ['categories'] }) // reload categories saja
      },
    }
  )
}

// Update Portofolio
function updatePortofolio() {
  const data = new FormData()
  data.append('title', form.value.title)
  data.append('description', form.value.description || '')
  data.append('tools', form.value.tools || '')
  data.append('category_id', form.value.category_id)
  if (form.value.image) data.append('image', form.value.image)
  data.append('_method', 'PUT') // wajib untuk Laravel

  router.post(`/admin/portofolio/${props.portofolio.id}`, data, {
    forceFormData: true,
    onSuccess: () => router.visit('/admin/portofolio'),
  })
}
</script>

<style scoped>
.input {
  @apply w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
