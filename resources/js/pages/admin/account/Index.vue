<template>
    <Head title=" Company Information" />
  <AppLayout :breadcrumbs="breadcrumbs">
  
   

     <form @submit.prevent="submit" class="space-y-6 p-6 max-w-4xl">
      <!-- Account Type Toggle -->
      <!-- <div class="flex items-center gap-4">
        <span :class="{ 'font-semibold': !isCompany }">Individual</span>
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" v-model="isCompany" class="sr-only peer" />
          <div
            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700
            peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px]
            after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
            peer-checked:bg-blue-600"
          ></div>
        </label>
        <span :class="{ 'font-semibold': isCompany }">Company</span>
      </div> -->

      <!-- User Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <BaseInput v-model="form.name" label="Full Name" placeholder="John Doe" />
        <BaseInput v-model="form.email" label="Email Address" placeholder="email@example.com" type="email" />
        <BaseInput v-model="form.phone" label="Phone" placeholder="e.g. +971..." />
        <BaseInput v-model="form.whatsapp" label="WhatsApp" placeholder="e.g. +971..." />
      </div>

      <!-- Location Info -->
      
    <LocationSelector
      v-model="form.location"
      :countries="countries"
      :cities="cities"
    />
      

      <!-- Social Media -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <BaseInput v-model="form.facebook" label="Facebook" placeholder="https://facebook.com/..." />
        <BaseInput v-model="form.instagram" label="Instagram" placeholder="https://instagram.com/..." />
       
      </div>

      <CompanyProfileForm   v-if="form.account_type === 'company'"
        v-model:company="form.company" />

      

      <Button type="submit" class="w-full mt-4">Save Profile</Button>
    </form>
  
  </AppLayout>
</template>

<script setup lang="ts">
import { ref,watch } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'

import 'leaflet/dist/leaflet.css'
import AppLayout from '@/layouts/AppLayout.vue'
import { User,Country,City,type BreadcrumbItem } from '@/types'
import BaseInput from '@/components/BaseInput.vue'
import { toast } from 'vue3-toastify'
import axios from 'axios';
import CompanyProfileForm from './CompanyProfileForm.vue'
import LocationSelector from '@/components/LocationSelector.vue'
const props = defineProps<{
  user:User,
  countries:Country[],
  cities:City[],
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Company Information',
        href: 'dashboard/company',
    },
];



// fill info
const form = useForm({
  
  name: props.user?.name || '',
  email: props.user?.email || '',
  phone: props.user?.phone || '',
  whatsapp: props.user?.whatsapp || '',
  
  facebook: props.user?.facebook || '',
  instagram: props.user?.instagram || '',
  
  account_type: props.user?.account_type || 'individual',

   location: {
    country_id: props.user?.country_id ?? null,
    city_id: props.user?.city_id ?? null,
    address: props.user?.address ?? '',
    latitude: props.user?.latitude ?? null,
    longitude: props.user?.longitude ?? null,
  },
  
  company: {
    name: props.user?.company?.name || '',
    slug: props.user?.company?.slug || '',
    industry: props.user?.company?.industry || '',
    logo: props.user?.company?.logo || '',
    description: props.user?.company?.description || '',
    website: props.user?.company?.website || '',
    tax_id: props.user?.company?.tax_id || '',
    registration_number: props.user?.company?.registration_number || '',
    is_verified: props.user?.company?.is_verified || false,
    is_active: props.user?.company?.is_active ?? true,
  },
})

const isCompany = ref(form.account_type === 'company')

watch(isCompany, (value) => {
  form.account_type = value ? 'company' : 'individual'
})



async function submit() {
  const formData = new FormData();


  formData.append('name', form.name);
  formData.append('email', form.email);
  formData.append('phone', form.phone ?? '');
  formData.append('whatsapp', form.whatsapp ?? '');
  formData.append('account_type', form.account_type);

 
  formData.append('country_id', String(form.location.country_id ?? ''));
  formData.append('city_id', String(form.location.city_id ?? ''));
  formData.append('address', form.location.address ?? '');
  formData.append('latitude', String(form.location.latitude ?? ''));
  formData.append('longitude', String(form.location.longitude ?? ''));

 
  formData.append('facebook', form.facebook ?? '');
  formData.append('instagram', form.instagram ?? '');

  
  if (form.account_type === 'company') {
    formData.append('company[name]', form.company.name);
    formData.append('company[slug]', form.company.slug ?? '');
    formData.append('company[industry]', form.company.industry ?? '');
    formData.append('company[logo]', form.company.logo ?? '');
    formData.append('company[description]', form.company.description ?? '');
    formData.append('company[website]', form.company.website ?? '');
    formData.append('company[tax_id]', form.company.tax_id ?? '');
    formData.append('company[registration_number]', form.company.registration_number ?? '');
    formData.append('company[is_verified]', form.company.is_verified ? '1' : '0');
    formData.append('company[is_active]', form.company.is_active ? '1' : '0');
  }

  formData.append('_method', 'PUT');

  try {
    const response = await axios.post(`/dashboard/account/update`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    toast.success(response?.data.message || 'Profile updated successfully!');
  } catch (err) {
    console.error(err);
    toast.error('Something went wrong while updating the profile.');
  }
}




</script>


