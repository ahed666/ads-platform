<!-- components/CompanyProfileForm.vue -->
<script setup lang="ts">
import BaseInput from '@/components/BaseInput.vue';
import { Company } from '@/types';

const props = defineProps<{
    company: Partial<Company>


}>();
const company=props.company
</script>
<template>
  <div class="space-y-6 border-t pt-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-800">Company Information</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <BaseInput v-model="company.name" label="Company Name" placeholder="Company Name" />
      <BaseInput v-model="company.slug" label="Slug" placeholder="slug-company" />
      <BaseInput v-model="company.logo" label="Logo URL" placeholder="https://..." />
      <BaseInput v-model="company.industry" label="Industry" placeholder="E.g. Tech, Construction..." />
    </div>

    <BaseInput v-model="company.description" label="Description" placeholder="Brief company description" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <BaseInput v-model="company.website" label="Website" />
      <BaseInput v-model="company.tax_id" label="Tax ID" />
      <BaseInput v-model="company.registration_number" label="Registration Number" />
    </div>
  </div>
</template>


