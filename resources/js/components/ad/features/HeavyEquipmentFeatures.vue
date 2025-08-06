<!-- <script setup lang="ts">
import {  reactive, watch } from 'vue';
import type { FeatureSet } from '@/types';
import BaseInput from '@/components/BaseInput.vue';
import FeatureTemplate from './FeatureTemplate.vue';
import { heavyFeatureFields } from '@/data/adFeatures';

const props = defineProps<{ features: FeatureSet }>();
const emit = defineEmits(['update:features']);
const localFeatures=reactive({...props.features})
watch(
  ()=>localFeatures,
  ()=>{
        emit('update:features', { ...localFeatures });

  },
  {deep:true}
);
</script>

<template>
   <FeatureTemplate>
         <BaseInput
    v-for="field in heavyFeatureFields"
    :key="field.key"
    :label="field.label"
    :placeholder="field.placeholder"
    v-model="localFeatures[field.key]"
  />
    
    </FeatureTemplate>
    
  
</template> -->
