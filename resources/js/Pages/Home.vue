<template>
    <AppLayout>
        <!-- HERO -->
        <section ref="heroRef"
            class="relative min-h-[600px] flex items-center justify-center overflow-hidden rounded-3xl mx-4 md:mx-8 mt-4">
            <div class="absolute inset-0 from-amber-900/70 to-amber-700/60">
                <img src="https://png.pngtree.com/background/20250107/original/pngtree-yellow-watercolor-batik-repeat-die-multi-craft-picture-image_15703879.jpg"
                    alt="Handcrafted keychains background"
                    class="w-full h-full object-cover mix-blend-overlay opacity-80" />
            </div>

            <div class="absolute inset-0 opacity-20">
                <svg class="w-full h-full" viewBox="0 0 1440 630" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="batik-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                        <circle cx="25" cy="25" r="20" fill="white" opacity="0.3" />
                        <circle cx="75" cy="75" r="15" fill="white" opacity="0.2" />
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#batik-pattern)" />
                </svg>
            </div>

            <div class="relative z-10 text-center px-6 py-20 max-w-5xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg leading-tight">
                    Discover the Art of Winomuah
                </h1>
                <p class="text-white text-lg md:text-xl mb-8 max-w-3xl mx-auto leading-relaxed drop-shadow">
                    Explore our curated collection of handcrafted goods, collaborating the rich heritage of African
                    craftsmanship.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/products"
                        class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Order Now
                    </a>
                    <button @click="scrollToCustom"
                        class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-amber-600 font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Design Your Own
                    </button>
                </div>
            </div>
        </section>

        <!-- FEATURED PRODUCTS -->
        <section ref="productsRef" id="products" class="py-20 px-4 md:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
                    Featured Products
                </h2>

                <!-- Produk dari database -->
                <div v-if="props.products.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <ProductCard v-for="product in props.products" :key="product.id" :product="{
                        title: product.name,
                        image: product.image ? product.image : '/assets/placeholder.png',
                        price: `Rp ${Number(product.price).toLocaleString('id-ID')}`,
                    }" @click="openProductModal(product)" />
                </div>

                <!-- Pesan jika belum ada produk -->
                <p v-else class="text-gray-500 text-center text-lg italic mt-6">
                    Belum ada produk yang tersedia.
                </p>

                <div class="flex justify-center mt-12">
                    <button
                        class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-3 rounded-xl transition-all duration-300">
                        View Full Catalog
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- PORTOFOLIO -->
        <section ref="portofolioRef" class="py-20 px-4 md:px-8 bg-gradient-to-b from-amber-50 to-white">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
                    Portofolio
                </h2>

                <!-- Portofolio dari database -->
                <div v-if="props.portofolios.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <PortofolioCard v-for="portofolio in props.portofolios" :key="portofolio.id" :portofolio="{
                        title: portofolio.title,
                        description: portofolio.description,
                        image: portofolio.image ? portofolio.image : '/assets/placeholder.png',
                    }" />
                </div>

                <!-- Pesan jika belum ada portofolio -->
                <p v-else class="text-gray-500 text-center text-lg italic mt-6">
                    Belum ada portofolio yang tersedia.
                </p>

                <div class="flex justify-center mt-12">
                    <button
                        class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-3 rounded-xl transition-all duration-300">
                        View Full Portofolio
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- CUSTOM SECTION -->
        <section ref="customRef" class="py-20 px-4 md:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
                    Custom Keychain & Custom Drawing
                </h2>

                <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="rounded-2xl overflow-hidden shadow-xl">
                        <img src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/107/MTA-177923951/hello-topper_custom-keychain-gantungan-kunci-acrylic-akrilik_full01.jpg"
                            alt="Custom Keychain Example" class="w-full h-full object-cover aspect-[4/3]" />
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800">
                            Your Custom Keychain & Drawing
                        </h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Turn your ideas into reality with our custom keychain design service.
                            Our team of skilled designers will work with you to create a unique
                            keychain that perfectly reflects your style and personality.
                        </p>
                        <button
                            class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105">
                            See More
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT -->
        <section id="contact" ref="contactRef" class="py-20 px-4 md:px-8 bg-gradient-to-b from-white to-amber-50">
            <div class="max-w-3xl mx-auto text-center space-y-8">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800">Contact Me</h2>
                <p class="text-gray-600 text-lg md:text-xl">
                    For inquiries or custom orders, please reach out to us via WhatsApp.
                </p>
                <a href="https://wa.me/+6289649079690" target="_blank"
                    class="inline-flex items-center gap-3 bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884" />
                    </svg>
                    Contact Via WhatsApp
                </a>
            </div>
        </section>

        <a href="https://wa.me/+6289649079690" target="_blank"
            class="fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 z-40"
            aria-label="Contact via WhatsApp">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884" />
            </svg>
        </a>

        <ProductModal :product="selectedProduct" @close="selectedProduct = null" />
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import AppLayout from './AppLayout.vue'
import ProductCard from '../Components/ProductCard.vue'
import PortofolioCard from '../Components/PortofolioCard.vue'
import ProductModal from '../Components/ProductModal.vue'

gsap.registerPlugin(ScrollTrigger)

// Props dari Laravel
const props = defineProps({
    products: Array,
    portofolios: Array,
})

// Refs
const heroRef = ref(null)
const productsRef = ref(null)
const portofolioRef = ref(null)
const customRef = ref(null)
const contactRef = ref(null)

// Modal state
const selectedProduct = ref(null)

// Methods
const openProductModal = (product) => {
    selectedProduct.value = product
}

const scrollToCustom = () => {
    customRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' })
}

// Animation setup
onMounted(async () => {
    await nextTick()
    const sections = [heroRef, productsRef, portofolioRef, customRef, contactRef]
    sections.forEach((section) => {
        if (section.value) {
            gsap.from(section.value, {
                opacity: 0,
                y: 60,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: section.value,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                },
            })
        }
    })
})
</script>

<style scoped>
html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #f59e0b;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #d97706;
}
</style>
