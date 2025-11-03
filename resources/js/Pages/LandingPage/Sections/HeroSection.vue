<template>
  <section
    class="relative min-h-[600px] flex items-center justify-center overflow-hidden rounded-3xl mx-4 md:mx-8 mt-4"
  >
    <div class="absolute inset-0 bg-black/10">
      <img
        src="/public/assets/BG-Hero2.jpg"
        alt="Handcrafted keychains background"
        class="w-full h-full object-cover mix-blend-overlay opacity-100"
      />
    </div>

    <div class="absolute inset-0 opacity-20">
      <svg class="w-full h-full" viewBox="0 0 1440 630" fill="none">
        <pattern id="batik-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
          <circle cx="25" cy="25" r="20" fill="white" opacity="0.3" />
          <circle cx="75" cy="75" r="15" fill="white" opacity="0.2" />
        </pattern>
        <rect width="100%" height="100%" fill="url(#batik-pattern)" />
      </svg>
    </div>

    <div class="relative z-10 text-center px-6 py-20 max-w-5xl mx-auto">
      <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg leading-tight">
        Discover the Art of Winomuah
      </h1>
      <p class="text-white text-lg md:text-xl mb-8 max-w-3xl mx-auto leading-relaxed drop-shadow">
        Explore our curated collection of handcrafted goods,
        collaborating the rich heritage of African craftsmanship.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a
          href="/products"
          class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg"
        >
          Order Now
        </a>
        <button
          @click="$emit('scroll-to', 'custom')"
          class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-amber-600 font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg"
        >
          Design Your Own
        </button>
      </div>
    </div>
  </section>
</template>
