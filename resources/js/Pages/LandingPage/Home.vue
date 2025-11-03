<template>
    <AppLayout>
        <!-- HERO -->
        <HeroSection @scroll-to="scrollToSection" />

        <!-- FEATURED PRODUCTS -->
        <FeaturedProducts
            :products="props.products"
            @open-modal="openProductModal"
        />

        <!-- PORTFOLIO -->
        <PortfolioSection
            :portofolios="props.portofolios"
            @open-modal="openPortofolioModal"
        />

        <!-- CUSTOM SECTION -->
        <CustomSection @open-modal="openCustomModal" />

        <!-- CONTACT -->
        <ContactSection />

        <!-- WhatsApp FAB -->
        <WhatsAppFAB />

        <!-- Modals -->
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
import { ref, onMounted, nextTick } from "vue";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

// Layout Utama
import AppLayout from "../AppLayout.vue";

// === SECTIONS (baru, dari folder Sections) ===
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

gsap.registerPlugin(ScrollTrigger);

// Props dari Laravel
const props = defineProps({
    products: Array,
    portofolios: Array,
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

const scrollToSection = (sectionId) => {
    const section = document.getElementById(`${sectionId}-section`);
    section?.scrollIntoView({ behavior: "smooth", block: "center" });
};

// Animations
onMounted(async () => {
    await nextTick();

    const sections = document.querySelectorAll("section");
    sections.forEach((section) => {
        gsap.from(section, {
            opacity: 0,
            y: 60,
            duration: 1,
            ease: "power3.out",
            scrollTrigger: {
                trigger: section,
                start: "top 80%",
                toggleActions: "play none none reverse",
            },
        });
    });
});
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
