<template>
  <div class="space-y-4 bg-white p-6 rounded-2xl shadow-md border">
    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">🔧 Custom Attributes</h3>
     
    <div
      v-for="(attr, index) in localAttributes"
      :key="index"
      class="grid grid-cols-5 gap-2 items-end"
    >
      <div class="col-span-1">
        <BaseInput
          label="Key"
          placeholder="e.g., Color"
          v-model="attr.key"
        />
      </div>

       <div class="col-span-3 grid grid-cols-3 gap-2">
        <BaseInput
          label="Label EN"
          placeholder="e.g., Red"
          v-model="attr.value.label_en"
        />
        <BaseInput
          label="Label AR"
          placeholder="مثال: أحمر"
          v-model="attr.value.label_ar"
        />
        <BaseInput
          label="Value"
          placeholder="e.g., red"
          v-model="attr.value.value"
        />
      </div>

      <div class="col-span-1">
        <button
          type="button"
          class="w-full h-10 rounded-xl bg-red-100 hover:bg-red-200 text-red-600 text-sm font-medium"
          @click="removeAttribute(index)"
        >
          🗑 Remove
        </button>
      </div>
    </div>

    <button
      type="button"
      class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm"
      @click="addAttribute"
    >
      ➕ Add Attribute
    </button>
  </div>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue';
import BaseInput from '@/components/BaseInput.vue';
import { AttributeItem } from '@/types';


const props = defineProps<{
  attributes: AttributeItem[];
}>();

const emit = defineEmits(['update:attributes']);

const localAttributes = reactive<AttributeItem[]>([...props.attributes]);

watch(
  localAttributes,
  () => {
     console.log(localAttributes);
    emit('update:attributes', [...localAttributes]);
  },
  { deep: true }
);

const addAttribute = () => {
 localAttributes.push({
    key: '',
    value: {
      label_en: '',
      label_ar: '',
      value: ''
    }
  });
};

const removeAttribute = (index: number) => {
  localAttributes.splice(index, 1);
};
</script>
