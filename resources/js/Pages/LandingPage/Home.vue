<template>
    <AppLayout>
        <HeroSection :company="props.company" @scroll-to="scrollToSection" />

        <FeaturedProducts
            :products="props.products"
            @open-modal="openProductModal"
        />

        <PortfolioSection
            :portofolios="props.portofolios"
            @open-modal="openPortofolioModal"
        />

        <CustomSection @open-modal="openCustomModal" />

        <ContactSection />

        <WhatsAppFAB />

        <ProductModal
            v-if="selectedProduct"
            :product="selectedProduct"
            @close="selectedProduct = null"
        />
        <PortofolioModal
            v-if="selectedPortofolio"
            :portofolio="selectedPortofolio"
            @close="selectedPortofolio = null"
        />

        <CustomModal
            v-if="showCustomModal"
            :isOpen="showCustomModal"
            @close="closeCustomModal"
        />
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

// Layout Utama
import AppLayout from "../AppLayout.vue";

// === SECTIONS ===
import HeroSection from "./Sections/HeroSection.vue";
import FeaturedProducts from "./Sections/FeaturedProducts.vue";
import PortfolioSection from "./Sections/PortfolioSection.vue";
import CustomSection from "./Sections/CustomSection.vue";
import ContactSection from "./Sections/ContactSection.vue";
import WhatsAppFAB from "@/Components/WhatsAppFAB.vue";

// === KOMPONEN GLOBAL ===
import ProductModal from "@/Components/ProductModal.vue";
import PortofolioModal from "@/Components/PortofolioModal.vue";
import CustomModal from "@/Components/CustomModal.vue";

// Registrasi GSAP
gsap.registerPlugin(ScrollTrigger);

// Props dari Laravel
const props = defineProps({
    products: Array,
    portofolios: Array,
    company: Object, // <<< PROPS BARU UNTUK BANNER HERO
});

// State
const selectedProduct = ref(null);
const showCustomModal = ref(false);

// Methods
const openProductModal = (product) => (selectedProduct.value = product);
const openCustomModal = () => (showCustomModal.value = true);
const closeCustomModal = () => (showCustomModal.value = false);

const selectedPortofolio = ref(null);
const openPortofolioModal = (portofolio) => {
    selectedPortofolio.value = portofolio;
};

// FUNGSI SCROLL
const scrollToSection = (sectionId) => {
    const section = document.getElementById(sectionId);

    if (section) {
        const navbarHeight = 80;
        const sectionTop = section.getBoundingClientRect().top + window.scrollY;

        window.scrollTo({
            top: sectionTop - navbarHeight,
            behavior: "smooth",
        });
    }
};
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
