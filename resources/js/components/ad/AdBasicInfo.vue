<!-- components/AdBasicInfo.vue -->
<template>
  <section class="border rounded p-4">
    <h2 class="text-lg font-semibold mb-4">2. Basic Information</h2>
    <div class="grid grid-cols-2 gap-4">
      <BaseInput
        v-model="nameEn"
        label="Ad Name (English)"
        placeholder="Enter product name"
      />
      <BaseInput
        v-model="nameAr"
        label="Ad Name (Arabic)"
        placeholder="أدخل اسم المنتج"
      />
      <div>
        <label class="block text-sm font-medium text-gray-700">Description (English)</label>
        <textarea
          v-model="descriptionEn"
          class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Enter product description"
          rows="3"
        ></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Description (Arabic)</label>
        <textarea
          v-model="descriptionAr"
          class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="أدخل وصف المنتج"
          rows="3"
        ></textarea>
      </div>
      <BaseInput
        v-model="price"
        label="Price"
        type="number"
        placeholder="Enter price"
      />
    </div>
  </section>
</template>

<script setup lang="ts">
import { AdForm } from '@/types';
import BaseInput from '../BaseInput.vue';
import { computed } from 'vue';
const props = defineProps<{
 form:AdForm;
}>();


const emit = defineEmits<{
  (e: 'update:form', value: AdForm): void;
}>();
// Use computed setters to avoid direct mutation
const nameEn = computed({
  get: () => props.form.name_en,
  set: (val) => emit('update:form', { ...props.form, name_en: val }),
});

const nameAr = computed({
  get: () => props.form.name_ar,
  set: (val) => emit('update:form', { ...props.form, name_ar: val }),
});

const descriptionEn = computed({
  get: () => props.form.description_en,
  set: (val) => emit('update:form', { ...props.form, description_en: val }),
});

const descriptionAr = computed({
  get: () => props.form.description_ar,
  set: (val) => emit('update:form', { ...props.form, description_ar: val }),
});

const price = computed({
  get: () => props.form.price,
  set: (val) => emit('update:form', { ...props.form, price: val }),
});

</script>
