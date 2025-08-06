<template>
  <div class="space-y-1 2xl:col-span-1 xl:col-span-1 md:col-span-2">
    <label v-if="label" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <select
      class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
      :value="modelValue"
      @change="$emit('update:modelValue', castValue($event.target.value))"
    >
      <option disabled value="">select one</option>
      <option
        v-for="item in options"
        :key="item[valueKey]"
        :value="item[valueKey]"
      >
        {{ item[labelKey] }}
      </option>
    </select>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  modelValue: string | number | null;
  options: any[];
  valueKey?: string;
  labelKey?: string;
  label?: string;
}>()

const emit = defineEmits(['update:modelValue'])

function castValue(val: string): number | string | null {
  if (val === '') return null
  const asNumber = Number(val)
  return isNaN(asNumber) ? val : asNumber
}
</script>
