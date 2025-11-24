<script setup>
import { ref, onMounted, nextTick } from "vue";
import { Link } from "@inertiajs/vue3";
import MainLayout from "../AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import WhatsAppFAB from "@/Components/WhatsAppFAB.vue";
import { gsap } from "gsap"; // Import GSAP

// Props dari Laravel Controller
const props = defineProps({
    product: Object,
});

// State untuk gambar yang dipilih
const selectedImage = ref(props.product.image);

// Array thumbnail images (main image + duplicates untuk demo)
const thumbnails = [
    props.product.image,
    props.product.image,
    props.product.image,
].filter(Boolean);

// Function untuk ganti gambar utama
const selectImage = (imageUrl) => {
    // Animasi transisi gambar sederhana saat diganti
    gsap.to(".main-product-image", {
        opacity: 0,
        duration: 0.2,
        onComplete: () => {
            selectedImage.value = imageUrl;
            gsap.to(".main-product-image", { opacity: 1, duration: 0.3 });
        }
    });
};

// --- ANIMASI HALAMAN ---
const breadcrumbRef = ref(null);
const productCardRef = ref(null);
const leftColRef = ref(null);
const rightColRef = ref(null);

onMounted(async () => {
    await nextTick(); // Tunggu DOM siap

    // 1. Initial State (Sembunyikan elemen)
    // Breadcrumb dari atas
    if (breadcrumbRef.value) gsap.set(breadcrumbRef.value, { y: -20, opacity: 0 });

    // Card Container (Zoom in dikit & fade)
    if (productCardRef.value) gsap.set(productCardRef.value, { y: 30, opacity: 0, scale: 0.98 });

    // Kolom Kiri (Gambar)
    if (leftColRef.value) gsap.set(leftColRef.value, { x: -30, opacity: 0 });

    // Kolom Kanan (Info) - Anak-anaknya kita stagger
    if (rightColRef.value) gsap.set(rightColRef.value.children, { x: 30, opacity: 0 });


    // 2. Timeline Animasi
    const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

    // Step A: Breadcrumb muncul
    if (breadcrumbRef.value) {
        tl.to(breadcrumbRef.value, { y: 0, opacity: 1, duration: 0.6 });
    }

    // Step B: Card Container muncul
    if (productCardRef.value) {
        tl.to(productCardRef.value, {
            y: 0,
            opacity: 1,
            scale: 1,
            duration: 0.8
        }, "-=0.4");
    }

    // Step C: Kiri & Kanan muncul bersamaan
    // Kiri (Gambar)
    if (leftColRef.value) {
        tl.to(leftColRef.value, { x: 0, opacity: 1, duration: 0.8 }, "-=0.6");
    }

    // Kanan (Info - Staggered)
    if (rightColRef.value) {
        tl.to(rightColRef.value.children, {
            x: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.1 // Muncul satu-satu (Judul -> Harga -> Kategori -> Tombol)
        }, "-=0.8");
    }
});
</script>

<template>
    <MainLayout>
        <div class="bg-gradient-to-b from-amber-50 to-white min-h-screen relative">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <nav ref="breadcrumbRef" class="flex items-center gap-2 text-sm mb-8 opacity-0">
                    <Link
                        href="/products"
                        class="text-amber-500 hover:text-amber-600 font-medium transition-colors"
                    >
                        Products
                    </Link>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-700 font-medium">{{ product.name }}</span>
                </nav>

                <div ref="productCardRef" class="bg-white rounded-3xl shadow-lg overflow-hidden opacity-0">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-10">

                        <div ref="leftColRef" class="space-y-4 opacity-0">
                            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-md relative group">
                                <img
                                    v-if="selectedImage"
                                    :src="selectedImage"
                                    :alt="product.name"
                                    class="main-product-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-gray-400"
                                >
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>

                        <div ref="rightColRef" class="space-y-6">

                            <div class="opacity-0">
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 leading-tight">
                                    {{ product.name }}
                                </h1>
                                <p class="text-gray-600 leading-relaxed text-base">
                                    {{ product.description || "No description available for this product." }}
                                </p>
                            </div>

                            <div class="border-t border-gray-200 opacity-0"></div>

                            <div class="space-y-2 opacity-0">
                                <h2 class="text-xl font-bold text-gray-900">Price</h2>
                                <p class="text-3xl font-bold text-amber-600">
                                    {{ product.price }}
                                </p>
                            </div>

                            <div class="border-t border-gray-200 opacity-0"></div>

                            <div class="space-y-2 opacity-0">
                                <h2 class="text-xl font-bold text-gray-900">Category</h2>
                                <span class="inline-block px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-medium text-sm">
                                    {{ product.category || "Uncategorized" }}
                                </span>
                            </div>

                            <div class="pt-4 space-y-3 opacity-0">
                                <a
                                    :href="`https://wa.me/${usePage().props.company.phone}?text=Hi, saya tertarik dengan produk ${product.name}`"
                                    target="_blank"
                                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-xl flex items-center justify-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 transform active:scale-95"
                                >
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    Order via WhatsApp
                                </a>

                                <Link
                                    href="/products"
                                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-6 rounded-xl flex items-center justify-center gap-2 transition-all duration-300 hover:bg-gray-300 active:scale-95"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                    Back to Products
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-50">
                <WhatsAppFAB />
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
/* Image transition animations */
.image-fade-enter-active,
.image-fade-leave-active {
    transition: opacity 0.3s ease;
}

.image-fade-enter-from,
.image-fade-leave-to {
    opacity: 0;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}
</style>
