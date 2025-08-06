<script setup lang="ts">
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const appName = usePage().props.appName as string
const isOpen = ref(false)
</script>

<template>
  <nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <Link :href="'/'" class="text-xl font-bold text-gray-800">{{ appName }}</Link>

      <!-- Hamburger Button (Mobile) -->
      <button
        @click="isOpen = !isOpen"
        class="md:hidden text-gray-600 focus:outline-none"
      >
        <svg v-if="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <!-- Links (Desktop) -->
      <div class="hidden md:flex items-center space-x-4 text-sm font-medium">
        <Link :href="'/products'" class="hover:text-blue-600">Products</Link>
        <Link :href="'/about'" class="hover:text-blue-600">About</Link>
        <Link :href="'/contact'" class="hover:text-blue-600">Contact</Link>
        <Link
          :href="route('login')"
          class="rounded border border-transparent px-4 py-1.5 hover:border-gray-300"
        >
          Log in
        </Link>
        <Link
          :href="route('register')"
          class="rounded border border-gray-300 px-4 py-1.5 hover:bg-gray-100"
        >
          Register
        </Link>
      </div>
    </div>

    <!-- Links (Mobile Dropdown) -->
    <div
      v-show="isOpen"
      class="md:hidden px-4 pb-4 space-y-2 text-sm font-medium transition-all"
    >
      <Link :href="'/products'" class="block text-gray-700 hover:text-blue-600">Products</Link>
      <Link :href="'/about'" class="block text-gray-700 hover:text-blue-600">About</Link>
      <Link :href="'/contact'" class="block text-gray-700 hover:text-blue-600">Contact</Link>
      <Link
        :href="route('login')"
        class="block text-gray-700 border border-transparent rounded px-4 py-2 hover:border-gray-300"
      >
        Log in
      </Link>
      <Link
        :href="route('register')"
        class="block text-gray-700 border border-gray-300 rounded px-4 py-2 hover:bg-gray-100"
      >
        Register
      </Link>
    </div>
  </nav>
</template>
