<template>
    <Transition
        enter-active-class="transition-opacity duration-300"
        enter-from-class="opacity-0"
        leave-active-class="transition-opacity duration-300"
        leave-to-class="opacity-0"
    >
        <div
            v-if="product"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 px-4"
            @click.self="$emit('close')"
        >
            <div
                class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl"
                @click.stop
            >
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
                    <h2 class="text-2xl font-bold text-gray-800">{{ product.name }}</h2>
                    <button
                        @click="$emit('close')"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-700"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 md:p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Image -->
                        <div class="space-y-4">
                            <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                                <img
                                    :src="imageUrl(product.image)"
                                    :alt="product.name"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div v-if="product.images && product.images.length" class="grid grid-cols-2 gap-3">
                                <div
                                    v-for="(img, idx) in product.images"
                                    :key="idx"
                                    class="aspect-square rounded-lg overflow-hidden bg-gray-100"
                                >
                                    <img
                                        :src="imageUrl(img)"
                                        :alt="`${product.name} ${idx + 1}`"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Price</h3>
                                <p class="text-2xl font-bold text-amber-600">
                                    {{ product.price }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Description</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ product.description || 'No description available for this product.' }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Category</h3>
                                <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-medium">
                                    {{ product.category || 'Uncategorized' }}
                                </span>
                            </div>

                            <a
                                class="block w-full bg-amber-500 hover:bg-amber-600 text-center text-white font-bold py-3 rounded-lg transition-colors"
                                :href="`https://wa.me/6281234567890?text=Halo, saya tertarik dengan produk ${product.name}`"
                                target="_blank"
                            >
                                Order via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        default: null
    }
})

defineEmits(['close'])

// Pastikan gambar bisa diakses dari public/storage
const imageUrl = (path) => {
    if (!path) return '/images/no-image.png'
    return path.startsWith('http') ? path : `/storage/${path}`
}
</script>
