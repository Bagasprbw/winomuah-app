<template>
  <transition name="fade">
    <div
      class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 px-4"
      @click.self="close"
    >
      <div
        ref="modalRef"
        class="bg-white max-w-5xl w-full rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh] relative"
      >
        <!-- Tombol Close -->
        <button
          @click="close"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

        <!-- Konten Modal -->
        <div class="p-8 md:p-12 space-y-8 text-gray-800">
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

          <!-- Card Kualitas -->
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

          <!-- Tentang Artis -->
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
  </transition>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { gsap } from "gsap";

const props = defineProps({
  isOpen: Boolean,
});
const emit = defineEmits(["close"]);

const modalRef = ref(null);

const close = () => {
  gsap.to(modalRef.value, { opacity: 0, y: 50, duration: 0.3 });
  setTimeout(() => emit("close"), 300);
};

const cards = [
  {
    title: "Exceptional Quality",
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
    title: "Handcrafted with Love",
    desc: "Each piece is made by hand, ensuring a personal touch that reflects creativity, warmth, and individuality.",
    image:
      "https://i.pinimg.com/originals/5a/bf/cc/5abfccd57bb0ef9441e82cdde30a1b3b.jpg",
  },
];

watch(
  () => props.isOpen,
  (newVal) => {
    if (newVal && modalRef.value) {
      gsap.fromTo(
        modalRef.value,
        { opacity: 0, y: 50 },
        { opacity: 1, y: 0, duration: 0.5, ease: "power3.out" }
      );
    }
  }
);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
