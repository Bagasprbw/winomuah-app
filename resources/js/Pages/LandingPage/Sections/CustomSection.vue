<template>
  <section id="custom-section" class="py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-12">
        Custom Keychain & Custom Drawing
      </h2>

      <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
        <div class="rounded-2xl overflow-hidden shadow-xl">
          <img
            src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/107/MTA-177923951/hello-topper_custom-keychain-gantungan-kunci-acrylic-akrilik_full01.jpg"
            alt="Custom Keychain Example"
            class="w-full h-full object-cover aspect-[4/3]"
          />
        </div>

        <div class="space-y-6">
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
