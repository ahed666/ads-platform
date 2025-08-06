<!-- components/BaseModal.vue -->
<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/30 backdrop-blur-xs">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
        
        <button @click="$emit('close')" class="absolute top-4 right-4 text-gray-500 hover:text-red-500">
          &times;
        </button>

        
        <slot />
      </div>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

defineProps<{
  show: boolean
}>()

 defineEmits<{
  (e: 'close'): void
}>()
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
}
</style>
