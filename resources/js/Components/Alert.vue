<template>
  <transition name="fade">
    <div
      v-if="visible"
      :class="[
        // TAMBAHKAN KELAS LEBAR DI SINI
        'fixed top-6 right-6 px-5 py-3 rounded-xl shadow-lg flex items-center space-x-3 z-50 max-w-md w-full min-w-[300px]',
        type === 'error'
          ? 'bg-red-100 border border-red-300 text-red-700'
          : 'bg-[#fff3e0] border border-[#fbc02d] text-[#795548]'
      ]"
    >
      <i
        :class="[
          'fa-solid text-lg',
          type === 'error' ? 'fa-circle-xmark text-red-500' : 'fa-circle-check text-[#f9a825]'
        ]"
      ></i>
      <span class="font-medium">{{ message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const visible = ref(false)
const message = ref('')
const type = ref('success')

// pantau flash message global
watch(
  () => page.props.flash,
  (flash) => {
    if (flash?.success) {
      message.value = flash.success
      type.value = 'success'
      showAlert()
    } else if (flash?.error) {
      message.value = flash.error
      type.value = 'error'
      showAlert()
    }
  },
  { deep: true, immediate: true }
)

function showAlert() {
  visible.value = true
  setTimeout(() => (visible.value = false), 4000)
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
