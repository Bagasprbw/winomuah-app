<template>
  <section ref="sectionRef" id="custom" class="py-20 px-8 md:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 ref="titleRef" class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
        Custom Keychain & Custom Drawing
      </h2>

      <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
        <div ref="imageRef" class="rounded-2xl overflow-hidden shadow-xl">
          <img
            src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/107/MTA-177923951/hello-topper_custom-keychain-gantungan-kunci-acrylic-akrilik_full01.jpg"
            alt="Custom Keychain Example"
            class="w-full h-full object-cover aspect-[4/3]"
          />
        </div>

        <div ref="contentRef" class="space-y-6">
          <h3 class="text-2xl md:text-3xl font-bold text-gray-800">
            Your Custom Keychain & Drawing
          </h3>
          <p class="text-gray-600 text-lg leading-relaxed">
            Turn your ideas into reality with our custom keychain design service.
            Our team of skilled designers will work with you to create a unique
            keychain that perfectly reflects your style and personality.
          </p>
          <button
            @click="$emit('open-modal')"
            class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105"
          >
            See More
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// --- Import Baru untuk Animasi ---
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

// --- Emits ---
defineEmits(['open-modal']);

// --- Logika Animasi GSAP ---
const sectionRef = ref(null);
const titleRef = ref(null);
const imageRef = ref(null);
const contentRef = ref(null);

onMounted(() => {
  // Sembunyikan elemen di awal
  gsap.set(titleRef.value, { opacity: 0, y: 30 });
  // Sembunyikan gambar, geser ke kiri
  gsap.set(imageRef.value, { opacity: 0, x: -30 });
  // Sembunyikan anak-anak konten, geser ke kanan
  gsap.set(contentRef.value.children, { opacity: 0, x: 30 });

  // Buat timeline dengan ScrollTrigger
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: sectionRef.value,
      start: "top 85%",
      toggleActions: "play none none reverse",
    }
  });

  // Animasikan judul
  tl.to(titleRef.value, {
    opacity: 1,
    y: 0,
    duration: 0.8,
    ease: "power2.out"
  });

  // Animasikan gambar (masuk dari kiri)
  tl.to(imageRef.value, {
    opacity: 1,
    x: 0,
    duration: 0.8,
    ease: "power2.out"
  }, "-=0.5");

  // Animasikan konten (h3, p, button) satu per satu (masuk dari kanan)
  tl.to(contentRef.value.children, {
    opacity: 1,
    x: 0,
    duration: 0.6,
    stagger: 0.1,
    ease: "power2.out"
  }, "-=0.5");
});
</script>
