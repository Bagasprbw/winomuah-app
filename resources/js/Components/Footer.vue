<template>
  <footer ref="footerRef" class="bg-[#fff3da] text-center py-6 text-gray-700 border-t">
    <div class="flex justify-center space-x-4 mb-3">
      <i class="fa-brands fa-tiktok text-xl"></i>
      <i class="fa-brands fa-instagram text-xl"></i>
    </div>
    <p class="text-sm">&copy; 2025 Winomuah Store. All rights reserved.</p>
    <p class="text-sm">Jl. Ir. Soekarno No.8 Surakarta, Jawa Tengah</p>
  </footer>
</template>

<script setup>
// --- Import Baru untuk Animasi ---
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

// --- Logika Animasi GSAP ---
const footerRef = ref(null);

onMounted(() => {
  // Pastikan elemennya ada
  if (footerRef.value && footerRef.value.children) {

    // Sembunyikan semua anak dari footer (div ikon, p, p)
    gsap.set(footerRef.value.children, { opacity: 0, y: 30 });

    // Buat timeline dengan ScrollTrigger
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: footerRef.value,
        start: "top 95%", 
        toggleActions: "play none none reverse",
      }
    });

    // Animasikan semua anak (div ikon, p, p) satu per satu
    tl.to(footerRef.value.children, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.15,
      ease: "power2.out"
    });
  }
});
</script>
