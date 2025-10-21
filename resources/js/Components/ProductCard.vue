<template>
    <div
        class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
        @click="$emit('click', product)"
    >
        <div class="aspect-[4/3] overflow-hidden bg-gray-100">
            <img
                :src="product.image"
                :alt="product.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
        </div>
        <div class="p-4 space-y-2">
            <h3 class="font-bold text-gray-800 text-lg">{{ product.title }}</h3>
            <p class="text-amber-600 font-semibold">{{ product.price }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true
    }
})

defineEmits(['click'])
</script>
