<template>
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <img
          src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Cat03.jpg"
          alt="Winomuah Logo"
          class="w-8 h-8 rounded-full"
        />
        <h1 class="text-xl font-bold">Winomuah Store</h1>
      </div>

      <nav class="hidden md:flex space-x-8 font-medium">
        <a href="#" class="hover:text-yellow-500">Home</a>
        <a href="#" class="hover:text-yellow-500">Products</a>
        <a href="#" class="hover:text-yellow-500">Portfolio</a>
        <a href="#" class="hover:text-yellow-500">Contact</a>
      </nav>

      <button class="text-yellow-500 md:hidden">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </header>
</template>
