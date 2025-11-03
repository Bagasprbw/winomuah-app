<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import MainLayout from "../AppLayout.vue";
import WhatsAppFAB from "@/Components/WhatsAppFAB.vue";

// Props dari Laravel Controller
const props = defineProps({
    products: Array,
});

// State untuk filter
const sortBy = ref("latest");
const priceRange = ref("all");
const categoryFilter = ref("all");

// Computed untuk produk yang difilter
const filteredProducts = computed(() => {
    let result = [...props.products];

    // Filter by category
    if (categoryFilter.value !== "all") {
        result = result.filter((p) => p.category === categoryFilter.value);
    }

    // Filter by price range
    if (priceRange.value !== "all") {
        result = result.filter((p) => {
            const price = parseInt(p.price.replace(/[^0-9]/g, ""));
            if (priceRange.value === "under10k") return price < 10000;
            if (priceRange.value === "10k-20k")
                return price >= 10000 && price <= 20000;
            if (priceRange.value === "above20k") return price > 20000;
            return true;
        });
    }

    // Sort
    if (sortBy.value === "name") {
        result.sort((a, b) => a.name.localeCompare(b.name));
    } else if (sortBy.value === "price-low") {
        result.sort((a, b) => {
            const priceA = parseInt(a.price.replace(/[^0-9]/g, ""));
            const priceB = parseInt(b.price.replace(/[^0-9]/g, ""));
            return priceA - priceB;
        });
    } else if (sortBy.value === "price-high") {
        result.sort((a, b) => {
            const priceA = parseInt(a.price.replace(/[^0-9]/g, ""));
            const priceB = parseInt(b.price.replace(/[^0-9]/g, ""));
            return priceB - priceA;
        });
    }

    return result;
});

// Extract unique categories dari products
const categories = computed(() => {
    const cats = props.products.map((p) => p.category).filter(Boolean);
    return [...new Set(cats)];
});
</script>

<template>
    <MainLayout>
        <!-- Header Section -->
        <div class="bg-gradient-to-b from-amber-50 to-white py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
                    Product Catalog
                </h1>
                <p class="text-lg text-gray-600">
                    Explore our collection of handcrafted and unique itemns
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Filter Section -->
            <div class="flex flex-wrap gap-3 mb-8">
                <!-- Sort By -->
                <div class="relative">
                    <select
                        v-model="sortBy"
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all cursor-pointer"
                    >
                        <option value="latest">Sort by</option>
                        <option value="name">Name (A-Z)</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="relative">
                    <select
                        v-model="priceRange"
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all cursor-pointer"
                    >
                        <option value="all">Price range</option>
                        <option value="under10k">Under Rp 10,000</option>
                        <option value="10k-20k">Rp 10,000 - 20,000</option>
                        <option value="above20k">Above Rp 20,000</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Category -->
                <div class="relative">
                    <select
                        v-model="categoryFilter"
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all cursor-pointer"
                    >
                        <option value="all">Category</option>
                        <option
                            v-for="cat in categories"
                            :key="cat"
                            :value="cat"
                        >
                            {{ cat }}
                        </option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <TransitionGroup
                name="products"
                tag="div"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8"
            >
                <Link
                    v-for="product in filteredProducts"
                    :key="product.id"
                    :href="`/products/${product.id}`"
                    class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                >
                    <!-- Product Image -->
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img
                            v-if="product.image"
                            :src="product.image"
                            :alt="product.name"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center text-gray-400"
                        >
                            <svg
                                class="w-16 h-16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3
                            class="font-semibold text-gray-900 text-lg mb-1 line-clamp-1 group-hover:text-amber-600 transition-colors"
                        >
                            {{ product.name }}
                        </h3>
                        <p class="text-sm font-medium text-gray-900">
                            {{ product.price }}
                        </p>
                    </div>
                </Link>
            </TransitionGroup>

            <!-- Pagination -->
            <div class="flex justify-center items-center gap-3 mt-8">
                <button
                    class="w-10 h-10 rounded-full bg-amber-400 hover:bg-amber-500 text-white flex items-center justify-center transition-colors shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>
                <button
                    class="w-10 h-10 rounded-full bg-amber-400 hover:bg-amber-500 text-white flex items-center justify-center transition-colors shadow-md hover:shadow-lg"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </button>
            </div>

            <!-- Empty State -->
            <div v-if="filteredProducts.length === 0" class="text-center py-16">
                <div class="text-gray-400 mb-4">
                    <svg
                        class="w-20 h-20 mx-auto"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                        />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    No products found
                </h3>
                <p class="text-gray-500">Try adjusting your filters</p>
            </div>
        </div>

        <!-- WhatsApp FAB -->
        <WhatsAppFAB/>
        
    </MainLayout>
</template>

<style scoped>
/* Transition animations untuk product cards */
.products-enter-active,
.products-leave-active {
    transition: all 0.5s ease;
}

.products-enter-from {
    opacity: 0;
    transform: translateY(30px);
}

.products-leave-to {
    opacity: 0;
    transform: scale(0.9);
}

.products-move {
    transition: transform 0.5s ease;
}

/* Smooth line-clamp */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
