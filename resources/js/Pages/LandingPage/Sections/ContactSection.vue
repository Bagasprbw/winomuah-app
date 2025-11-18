<template>
  <section ref="sectionRef" id="contact" class="py-20 px-4 md:px-8 bg-gradient-to-b from-white to-amber-50">
    <div ref="contentRef" class="max-w-3xl mx-auto text-center space-y-8">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-800">Contact Me</h2>
      <p class="text-gray-600 text-lg md:text-xl">
        For inquiries or custom orders, please reach out to us via WhatsApp.
      </p>
      <a
        href="https://wa.me/+6289649079690"
        target="_blank"
        class="inline-flex items-center gap-3 bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg"
      >
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
          <path
            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"
          />
        </svg>
        Contact Via WhatsApp
      </a>
    </div>
  </section>
</template>

<script setup>
// --- Import Baru untuk Animasi ---
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

// --- Logika Animasi GSAP ---
const sectionRef = ref(null);
const contentRef = ref(null);

onMounted(() => {
  gsap.set(contentRef.value.children, { opacity: 0, y: 30 });

  // Buat timeline dengan ScrollTrigger
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: sectionRef.value,
      start: "top 85%",
      toggleActions: "play none none reverse",
    }
  });

  // Animasikan elemen-elemen (h2, p, a) satu per satu
  tl.to(contentRef.value.children, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    stagger: 0.15,
    ease: "power2.out"
  });
});
</script>
