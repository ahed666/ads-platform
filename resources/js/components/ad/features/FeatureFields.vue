<script setup lang="ts">
import { watch, reactive, computed } from 'vue';
import type { FeatureSet } from '@/types';
import BaseInput from '@/components/BaseInput.vue';
import FeatureTemplate from './FeatureTemplate.vue';
import { adFeatures } from '@/data/adFeatures';

const props = defineProps<{
  features: FeatureSet,
  adType: string|null,
}>();
const emit = defineEmits(['update:features']);

const localFeatures = reactive({ ...props.features });

const featureFields = computed(() => {
  return props.adType ? adFeatures[props.adType]?.fields || [] : [];
});


watch(
  () => localFeatures,
  () => {
    emit('update:features', { ...localFeatures });
  },
  { deep: true }
);

</script>

<template>
   <FeatureTemplate>
   
     <BaseInput
      v-for="field in featureFields"
      :key="field.key"
      :label="field.label"
      :placeholder="field.placeholder"
      v-model="localFeatures[field.key]"
  />
    
  </FeatureTemplate>
</template>
