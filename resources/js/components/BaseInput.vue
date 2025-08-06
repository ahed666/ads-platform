<!-- components/BaseInput.vue -->
<template>
  <div class="space-y-1">
    <label v-if="label" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <input
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
    />
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: string |number| null|undefined;
  label?: string;
  placeholder?: string;
  type?: string;
}>();
defineEmits(['update:modelValue']);
</script>
