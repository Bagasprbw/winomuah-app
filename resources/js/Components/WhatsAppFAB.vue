<template>
    <a ref="fabRef" :href="`https://wa.me/${phone}?text=${encodeURIComponent(message)}`" target="_blank"
        rel="noopener noreferrer" class="fixed bottom-8 right-8 z-50 flex items-center justify-center group">
        <span
            class="absolute right-full mr-4 px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out -translate-x-4 group-hover:translate-x-0 pointer-events-none">
            Chat via WhatsApp
        </span>

        <div
            class="w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110">
            <svg class="w-8 h-8 text-white transition-transform duration-300 group-hover:rotate-12" fill="currentColor"
                viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 22.991h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884" />
            </svg>

        </div>
    </a>
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { gsap } from "gsap";

// Ambil data company dari Inertia
const page = usePage();
const company = computed(() => page.props.company ?? {});

// Nomor WhatsApp dari DB
const phone = computed(() => company.value.phone ?? "");

// Pesan default
const message = "Halo! Saya ingin bertanya mengenai produk yang ada di website.";

// Animasi FAB
const fabRef = ref(null);

onMounted(() => {
    gsap.set(fabRef.value, { scale: 0, opacity: 0 });

    gsap.to(fabRef.value, {
        scale: 1,
        opacity: 1,
        duration: 0.5,
        ease: "back.out(1.7)",
        delay: 1,
    });
});
</script>
