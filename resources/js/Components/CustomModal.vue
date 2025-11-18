<template>
  <div
    ref="backdropRef"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 px-4"
    @click.self="closeModal"
  >
    <div
      ref="contentRef"
      class="bg-white max-w-5xl w-full rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh] relative"
    >
      <button
        @click="closeModal"
        class="absolute top-6 right-6 w-11 h-11 bg-white/90 hover:bg-white rounded-full shadow-md flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 group z-20"
        aria-label="Close modal"
      >
        <svg
          class="w-5 h-5 text-gray-700 group-hover:text-gray-900"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <div ref="contentWrapperRef" class="p-8 md:p-12 space-y-8 text-gray-800">
        <div class="text-center space-y-4">
          <h2 class="text-3xl md:text-4xl font-bold">
            Why Request with Winomuah?
          </h2>
          <h3 class="text-xl md:text-2xl font-semibold text-amber-600">
            Unleash Your Creativity with Winomuah
          </h3>
          <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Di Winomuah, saya bantu mewujudkan ide kamu jadi karya yang unik
            dan personal — tidak hanya dalam bentuk gantungan kunci, tapi juga
            custom drawing digital sesuai keinginanmu. Saya selalu
            mengutamakan kualitas, desain yang sesuai karakter kamu, dan
            kepuasan hasil akhir — jadi kamu bisa dapat karya yang benar-benar
            mencerminkan dirimu.
          </p>
        </div>

        <div
          class="grid md:grid-cols-3 gap-8 mt-10"
        >
          <div
            v-for="(item, index) in cards"
            :key="index"
            class="bg-amber-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition"
          >
            <img
              :src="item.image"
              class="w-full h-52 object-cover"
              alt="Card Image"
            />
            <div class="p-6 space-y-3">
              <h4 class="font-bold text-lg text-gray-800">
                {{ item.title }}
              </h4>
              <p class="text-gray-600 text-sm leading-relaxed">
                {{ item.desc }}
              </p>
            </div>
          </div>
        </div>

        <div class="mt-12 border-t pt-8 text-center space-y-4">
          <h4 class="text-xl font-semibold text-gray-800">About the Artist</h4>
          <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Hi, I'm Winona Aurelia, the sole creator behind Winomuah. With a
            passion for design and craftsmanship, I personally handle every
            custom request — from digital drawings to handcrafted keychains.
            My goal is to provide a personalized experience, ensuring every
            piece I create truly reflects your unique style, story, and
            vision.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { gsap } from "gsap";

const props = defineProps({
  isOpen: Boolean,
});
const emit = defineEmits(["close"]);

// --- Refs ---
const backdropRef = ref(null);
const contentRef = ref(null);
const contentWrapperRef = ref(null);

// --- Fungsi Tutup Modal ---
const closeModal = async () => {
  if (!backdropRef.value) return;
  backdropRef.value.style.pointerEvents = "none";

  await new Promise((resolve) => {
    gsap.to(contentWrapperRef.value.children, {
      opacity: 0,
      y: 20,
      duration: 0.25,
      stagger: 0.05,
      ease: "power2.in"
    });

    gsap.to(contentRef.value, {
      opacity: 0,
      scale: 0.95,
      duration: 0.4,
      delay: 0.1,
      ease: "power2.in"
    });

    gsap.to(backdropRef.value, {
      opacity: 0,
      duration: 0.4,
      ease: 'power2.inOut',
      onComplete: resolve
    });
  });

  emit('close');
};

// --- Handle Escape ---
const handleEscape = (e) => {
  if (e.key === 'Escape') closeModal();
};

// --- Fungsi Animasi Masuk ---
const animateIn = () => {
  gsap.fromTo(
    backdropRef.value,
    { opacity: 0 },
    { opacity: 1, duration: 0.4, ease: 'power2.out' }
  );

  gsap.fromTo(
    contentRef.value,
    { scale: 0.9, opacity: 0 },
    { scale: 1, opacity: 1, duration: 0.5, ease: 'power3.out' }
  );

  gsap.fromTo(
    contentWrapperRef.value.children,
    { opacity: 0, y: 30 },
    {
      opacity: 1,
      y: 0,
      duration: 0.6,
      stagger: 0.1,
      delay: 0.3,
      ease: 'power3.out'
    }
  );
};

// --- Lifecycle Hooks ---
onMounted(() => {
  document.addEventListener('keydown', handleEscape);
  animateIn();
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
});

// --- Data Cards (FIX ADA DI SINI) ---
const cards = [
  {
    title: "Exceptional Quality", // <-- (FIX) Bukan 'title:s:'
    desc: "I use premium materials and meticulous craftsmanship to ensure your keychain is not only visually appealing but also durable and long-lasting.",
    image:
      "https://i.pinimg.com/originals/b2/fd/22/b2fd2243de03a7f7b3b2d01d08b23cf3.jpg",
  },
  {
    title: "Personalized Design",
    desc: "Every design is tailored uniquely for you — from digital sketches to handcrafted physical pieces that capture your essence.",
    image:
      "https://i.pinimg.com/originals/b8/89/36/b88936a7f2a82e6a71eb6a7063e4c83c.jpg",
  },
  {
    title: "Handcrafted with Love", // <-- (FIX) Bukan 'title:s:'
    desc: "Each piece is made by hand, ensuring a personal touch that reflects creativity, warmth, and individuality.",
    image:
      "https://i.pinimg.com/originals/5a/bf/cc/5abfccd57bb0ef9441e82cdde30a1b3b.jpg", // <-- (FIX) Bukan 'httpshttps://'
  },
];
</script>

<style scoped>
</style>
