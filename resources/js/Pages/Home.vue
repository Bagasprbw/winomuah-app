<template>
    <AppLayout>
        <!-- HERO SECTION -->
        <section ref="hero" class="relative text-center py-24 px-6 rounded-2xl overflow-hidden bg-gray-100">
            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=80"
                alt="Keychain background" class="absolute inset-0 w-full h-full object-cover opacity-40" />
            <div class="relative z-10 max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow">
                    Discover the Art of Winomuah
                </h1>
                <p class="text-white text-lg mb-6">
                    Explore our curated collection of handcrafted goods, collaborating
                    the rich heritage of African craftsmanship.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="/admin/dashboard" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg">
                        Order Now
                    </a>
                    <button
                        class="bg-white text-yellow-600 hover:text-yellow-700 font-semibold py-2 px-6 rounded-lg border border-yellow-500">
                        Design Your Own
                    </button>
                </div>
            </div>
        </section>

        <!-- FEATURED PRODUCTS -->
        <section ref="featured" class="py-16 text-center">
            <h2 class="text-3xl font-bold mb-8">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div v-for="(product, i) in products" :key="i"
                    class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer"
                    @click="openModal(product)">
                    <img :src="product.image" alt="Product" class="rounded-lg mx-auto mb-4 h-48 w-full object-cover" />
                    <h3 class="font-semibold text-gray-700">{{ product.title }}</h3>
                    <p class="text-gray-500">{{ product.price }}</p>
                </div>
            </div>
            <button class="mt-8 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium px-6 py-2 rounded-lg">
                View Full Catalog
            </button>
        </section>

        <!-- PORTFOLIO -->
        <section ref="portfolio" class="py-16 text-center bg-yellow-50">
            <h2 class="text-3xl font-bold mb-8">Portofolio</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div v-for="(img, i) in portfolioImages" :key="i"
                    class="p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <img :src="img" alt="Portfolio" class="rounded-lg mb-3 h-40 w-full object-cover" />
                    <h3 class="font-semibold">Judul Karya</h3>
                    <p class="text-sm text-gray-500">Deskripsi singkat karya</p>
                </div>
            </div>
            <button class="mt-8 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium px-6 py-2 rounded-lg">
                View Full Portofolio
            </button>
        </section>


        <!-- CUSTOM SECTION -->
        <section ref="custom" class="py-16 max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-10 px-6">
            <img src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/107/MTA-177923951/hello-topper_custom-keychain-gantungan-kunci-acrylic-akrilik_full01.jpg"
                alt="Custom Keychain" class="rounded-2xl w-full md:w-1/2 shadow" />
            <div class="text-left">
                <h2 class="text-2xl font-bold mb-2">Custom Keychain & Custom Drawing</h2>
                <h3 class="font-semibold text-gray-700 mb-4">
                    Your Custom Keychain & Drawing
                </h3>
                <p class="text-gray-600 mb-6">
                    Turn your ideas into reality with our custom keychain design service.
                    Our team of skilled designers will work with you to create a unique
                    keychain that perfectly reflects your style and personality.
                </p>
                <button class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium px-6 py-2 rounded-lg">
                    See More
                </button>
            </div>
        </section>

        <!-- CONTACT -->
        <section ref="contact" class="py-16 text-center bg-white">
            <h2 class="text-2xl font-bold mb-4">Contact Me</h2>
            <p class="text-gray-600 mb-6">
                For inquiries or custom orders, please reach out to us via WhatsApp.
            </p>
            <button
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg inline-flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-xl"></i>
                Contact Via WhatsApp
            </button>
        </section>

        <!-- PRODUCT MODAL -->
        <transition name="fade">
            <div v-if="selectedProduct" class="fixed inset-0 bg-black/60 flex justify-center items-center z-50 px-4">
                <div class="bg-white rounded-3xl p-6 md:p-8 max-w-4xl w-full relative overflow-y-auto max-h-[90vh]">
                    <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl"
                        @click="selectedProduct = null">
                        &times;
                    </button>

                    <h2 class="text-2xl font-bold text-center mb-4">
                        {{ selectedProduct.title }}
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <img :src="selectedProduct.image" alt="Product" class="rounded-xl w-full object-cover" />
                        <div class="flex flex-col gap-4">
                            <p><strong>Deskripsi:</strong><br />{{ selectedProduct.desc }}</p>
                            <p><strong>Price:</strong><br />{{ selectedProduct.price }}</p>
                            <p><strong>Bahan:</strong><br />{{ selectedProduct.material }}</p>
                            <p><strong>Kategori:</strong><br />{{ selectedProduct.category }}</p>
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <img v-for="(img, index) in selectedProduct.images" :key="index" :src="img"
                                    class="rounded-lg w-full h-28 object-cover" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
gsap.registerPlugin(ScrollTrigger)

import AppLayout from './AppLayout.vue'

const selectedProduct = ref(null)
const hero = ref(null)
const featured = ref(null)
const portfolio = ref(null) // ini ref DOM untuk animasi
const custom = ref(null)
const contact = ref(null)

const openModal = (product) => {
    selectedProduct.value = product
}

const products = [
    {
        title: 'Pochita Keychain',
        image:
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/101/MTA-182235926/no_brand_tumbler-termos_premium_stainless_steel_304_tumbler_sedotan_tahan_panas_dingin_500ml_bottle_kml-836_full01_kdfrsmlv.jpg',
        price: 'Rp 8,000',
        desc: 'Made with high-quality material, this keychain perfectly captures Pochita’s adorable look.',
        material: 'Kulit',
        category: 'Aksesoris',
        images: [
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/101/MTA-182235926/no_brand_tumbler-termos_premium_stainless_steel_304_tumbler_sedotan_tahan_panas_dingin_500ml_bottle_kml-836_full01_kdfrsmlv.jpg',
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/101/MTA-182235926/no_brand_tumbler-termos_premium_stainless_steel_304_tumbler_sedotan_tahan_panas_dingin_500ml_bottle_kml-836_full01_kdfrsmlv.jpg'
        ]
    },
    {
        title: 'Owl Crochet Keychain',
        image:
            'https://www.wayangstore.com/wp-content/uploads/2016/12/Gantungan-Kunci-Akrilik-Kamajaya-a.jpg',
        price: 'Rp 9,000',
        desc: 'Cute handmade owl keychain from cotton yarn.',
        material: 'Benang katun',
        category: 'Aksesoris',
        images: [
            'https://www.wayangstore.com/wp-content/uploads/2016/12/Gantungan-Kunci-Akrilik-Kamajaya-a.jpg',
            'https://www.wayangstore.com/wp-content/uploads/2016/12/Gantungan-Kunci-Akrilik-Kamajaya-a.jpg'
        ]
    },
    {
        title: 'Heart Brass Pendant',
        image:
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/114/MTA-138369579/brd-60517_cute-characters-on-doughnut-keychain-ganci-gantungan-kunci-imut-lucu-gift-goodie-bag-anak-souvenir-koleksi-collectible_full02-c7644815.jpg',
        price: 'Rp 9,000',
        desc: 'Elegant handcrafted brass pendant in heart shape.',
        material: 'Kuningan',
        category: 'Perhiasan',
        images: [
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/114/MTA-138369579/brd-60517_cute-characters-on-doughnut-keychain-ganci-gantungan-kunci-imut-lucu-gift-goodie-bag-anak-souvenir-koleksi-collectible_full02-c7644815.jpg',
            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/114/MTA-138369579/brd-60517_cute-characters-on-doughnut-keychain-ganci-gantungan-kunci-imut-lucu-gift-goodie-bag-anak-souvenir-koleksi-collectible_full02-c7644815.jpg'
        ]
    }
]

// 🔹 Ganti nama jadi portfolioImages agar tidak bentrok
const portfolioImages = [
    'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1549187774-b4e9b0445b06?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1473186505569-9c61870c11f9?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1581349480311-9c449d3d0b50?auto=format&fit=crop&w=600&q=80'
]

onMounted(() => {
    const sections = [hero, featured, portfolio, custom, contact]
    sections.forEach((section) => {
        gsap.from(section.value, {
            opacity: 0,
            y: 50,
            duration: 0.8,
            scrollTrigger: {
                trigger: section.value,
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        })
    })
})
</script>


<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
