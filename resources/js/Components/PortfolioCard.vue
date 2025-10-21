<template>
    <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
            <img
                :src="portfolio.image"
                :alt="portfolio.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
        </div>
        <div class="p-4 space-y-1 text-center">
            <h3 class="font-bold text-gray-800">{{ portfolio.title }}</h3>
            <p class="text-sm text-gray-600">{{ portfolio.description }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    portfolio: {
        type: Object,
        required: true
    }
})
</script>
