<template>
  <div class="flex items-center justify-center min-h-screen bg-[#fffaf3]">
    <div
      class="bg-white/70 backdrop-blur-lg shadow-xl rounded-2xl p-10 w-full max-w-md border border-[#ffe8c9]"
    >
      <!-- Logo & Nama Perusahaan -->
      <div class="flex flex-col items-center mb-8">
        <img
          v-if="company && company.logo"
          :src="`/storage/${company.logo}`"
          alt="Logo"
          class="w-16 h-16 object-contain mb-3"
        />
        <h2 class="text-2xl font-bold text-gray-800">
          {{ company?.company_name || 'Admin Panel' }}
        </h2>
        <p class="text-sm text-gray-500">Please sign in to access your dashboard</p>
      </div>

      <!-- 🔔 Alert Error -->
      <transition name="fade">
        <div
          v-if="showError && $page.props.errors.username"
          class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 border border-red-300 text-sm"
        >
          {{ $page.props.errors.username }}
        </div>
      </transition>

      <!-- Form -->
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">Username or Email</label>
          <input
            v-model="form.username"
            type="text"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
            required
          />
        </div>

        <div class="mb-6 relative">
          <label class="block text-gray-700 font-medium mb-1">Password</label>

          <!-- 🔐 Input password + toggle -->
          <input
            v-model="form.password"
            :type="showPassword ? 'text' : 'password'"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 focus:ring-2 focus:ring-[#f9a825] focus:outline-none"
            required
          />

          <!-- 👁️ Toggle icon -->
          <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute right-3 top-9 text-gray-500 hover:text-[#f9a825] focus:outline-none"
          >
            <svg
              v-if="!showPassword"
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
              />
            </svg>

            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.965 9.965 0 012.289-4.328M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18"
              />
            </svg>
          </button>
        </div>

        <button
          type="submit"
          class="w-full bg-[#f9a825] text-white font-semibold py-2 rounded-lg hover:bg-[#f57f17] transition"
        >
          Login
        </button>
      </form>

      <p class="text-center text-gray-500 text-sm mt-6">
        &copy; 2025 {{ company?.company_name || 'Winomuah' }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, watchEffect } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const props = defineProps({
  company: Object
})

const page = usePage()
const form = reactive({
  username: '',
  password: ''
})
const showError = ref(false)
const showPassword = ref(false)

function submit() {
  router.post('/login', form)
}

// 🔔 Auto-hide alert logic
watchEffect(() => {
  if (page.props.errors.username) {
    showError.value = true
    setTimeout(() => {
      showError.value = false
    }, 3000)
  }
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
