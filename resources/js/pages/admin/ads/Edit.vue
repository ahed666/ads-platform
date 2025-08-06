<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { computed, ref } from 'vue';
import axios from 'axios';
import type { Brand, BrandModel, AdForm,Category, Ad, SubCategory, AdType } from '@/types';

import { router } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import BaseSelect from '@/components/BaseSelect.vue';
import MediaUploader from '@/components/MediaUploader.vue';


import AdAttributes from '@/components/ad/AdAttributes.vue';
import FeatureFields from '@/components/ad/features/FeatureFields.vue';
const props = defineProps<{
    ad: Ad | null;
    categories: Category[];
    brands: Brand[];
    models: BrandModel[];
    subCategories: SubCategory[];
    adTypes:AdType[];
}>();
const deletedMedia=ref<number[]>([])



const purposesOptions=[
  { id: 'for_sale', purpose: 'For Sale' },
  { id: 'for_rent', purpose: 'For Rent' }
]


const statusOptions=[
    { id: 'active', status: 'Active' },
  { id: 'inactive', status: 'Inactive' },
  { id: 'archived', status: 'Archived' },
]
const availabilityOptions = [
  { id: 'available', availability: 'Available' },
  { id: 'sold', availability: 'Sold' },
  { id: 'rented', availability: 'Rented' },
]
const form = ref<AdForm>({
  category_id: props.ad?.category_id ?? null,
  subcategory_id: props.ad?.subcategory_id ?? null,
  brand_id: props.ad?.brand_id ?? null,
  model_id: props.ad?.model_id ?? null,
  ad_type_id:props.ad?.ad_type_id??null,
  name_en: props.ad?.name_en ?? '',
  name_ar: props.ad?.name_ar ?? '',
  description_en: props.ad?.description_en ?? '',
  description_ar: props.ad?.description_ar ?? '',
  price: props.ad?.price ?? null,
  images: props.ad?.images ?? [],
  video: props.ad?.video ?? null,
  status:props.ad?.status??'',
  purpose:props.ad?.purpose??'',
  availability:props.ad?.availability??'',
  features:props.ad?.features??{},
  attributes:props.ad?.attributes??[],
  
});
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Ads', href: '/dashboard/ads' },
  { title: props.ad?.name_en || 'Edit Ad', href: `/ads/${props.ad?.id}/edit` },
];

const filteredCategories = computed(() => {
    if (!form.value.ad_type_id) return [];
    return props.categories.filter((cat) => cat.ad_type_id === form.value.ad_type_id);
});

const filteredSubcategories = computed(() => {
    if (!form.value.category_id) return [];
    return props.subCategories.filter((cat) => cat.category_id === form.value.category_id);
});

const filteredBrands = computed(() => {
    if (!form.value.ad_type_id) return [];
    return props.brands.filter((brand) =>  brand.ad_type_id === form.value.ad_type_id);
});

const filteredModels = computed(() => {
    if (!form.value.brand_id) return [];
    return props.models.filter((model) => model.brand_id === form.value.brand_id);
});

function handleMediaDeleted(id: number) {
    if (!deletedMedia.value.includes(id)) {
        deletedMedia.value.push(id);
    }
}


async function submit() {
      console.log('edit pro attributes:', form.value.video);
    try {
        const formData = new FormData();
        formData.append('name_en', form.value.name_en);
        formData.append('name_ar', form.value.name_ar);
        formData.append('description_en', form.value.description_en);
        formData.append('description_ar', form.value.description_ar);
        formData.append('status', form.value.status);
        formData.append('purpose', form.value.purpose);
        formData.append('availability',form.value.availability);
        formData.append('features',JSON.stringify(form.value.features));
        formData.append('attributes',JSON.stringify(form.value.attributes));

        if (form.value.price)formData.append('price', form.value.price.toString());
        if (form.value.category_id) formData.append('category_id', form.value.category_id.toString());
        if (form.value.subcategory_id) formData.append('subcategory_id', form.value.subcategory_id.toString());
        if (form.value.brand_id) formData.append('brand_id', form.value.brand_id.toString());
        if (form.value.model_id) formData.append('model_id', form.value.model_id.toString());

        if (form.value.images && form.value.images.length) {
            form.value.images.forEach((img, idx) => {
                if (img.file) formData.append(`images[${idx}]`, img.file);
            });
        }

        
      if (
        form.value.video &&
        form.value.video.file &&
        form.value.video.file instanceof File
        ) {
            console.log('file',form.value.video.file);
        formData.append('video', form.value.video.file);
        }
  // else: it's probably a string path, don't append


        
      deletedMedia.value.forEach((id) => {
            formData.append('deletedMedia[]', id.toString());
        });

        
            //edit ad
           formData.append('_method', 'PUT');
            const response = await axios.post(`/dashboard/ads/${props.ad?.id}`, formData, {
                headers: {
                    
                },
            });
        
          toast.success(response.data.message || 'Ad created successfully!');

          router.visit('/dashboard/ads');

       
    } catch (error: any) {
            toast.error(error.response?  error.message : 'Failed to create ad.');
    }
}
</script>
<template>
    <Head title="Edit Ad" />
   

    <AppLayout :breadcrumbs="breadcrumbs">
    
     <form @submit.prevent="submit" class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid grid-cols-2 gap-1" >
                <BaseSelect  v-model="form.ad_type_id" :options="adTypes" valueKey="id" labelKey="name_en" label="Ad Type" required />
                <BaseSelect  v-model="form.category_id" :options="filteredCategories" valueKey="id" labelKey="name_en" label="Category" required />
                <BaseSelect
                  
                    v-model="form.subcategory_id"
                    :options="filteredSubcategories"
                    :valueKey="'id'"
                    :labelKey="'name_en'"
                    :label="'Sub Category'"
                />
                <BaseSelect
                    v-model="form.brand_id"
                    :options="filteredBrands"
                    :valueKey="'id'"
                    :labelKey="'name_en'"
                    :label="'Brand'"
                />
                <BaseSelect
                    v-model="form.model_id"
                    :options="filteredModels"
                    :valueKey="'id'"
                    :labelKey="'name_en'"
                    :label="'Model'"
                />
            </div>

            <div class="grid grid-cols-2 gap-1">
                <div class="2xl:col-span-1 xl:col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium">Ad Name (English)</label>
                    <input v-model="form.name_en" type="text" class="w-full rounded border p-2" required />
                </div>
                <div class="2xl:col-span-1 xl:col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium">Ad Name (Arabic)</label>
                    <input v-model="form.name_ar" type="text" class="w-full rounded border p-2" required />
                </div>
                <div class="2xl:col-span-1 xl:col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium">Description (English)</label>
                    <textarea v-model="form.description_en" class="w-full rounded border p-2" required />
                </div>
                <div class="2xl:col-span-1 xl:col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium">Description (Arabic)</label>
                    <textarea v-model="form.description_ar" class="w-full rounded border p-2" required />
                </div>
                <div class="2xl:col-span-1 xl:col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium">Price</label>
                    <input v-model.number="form.price" type="number" class="w-full rounded border p-2" min="0" step="0.01" required />
                </div>

                <BaseSelect
                    v-model="form.purpose"
                    :options="purposesOptions"
                    :valueKey="'id'"
                    :labelKey="'purpose'"
                    :label="'Purpose'"
                />
                <!-- availabilty -->
                 <BaseSelect
                    v-model="form.availability"
                    :options="availabilityOptions"
                    :valueKey="'id'"
                    :labelKey="'availability'"
                    :label="'Availability'"
                />

                <!-- Ad Status -->
                <BaseSelect
                    v-model="form.status"
                    :options="statusOptions"
                    :valueKey="'id'"
                    :labelKey="'status'"
                    :label="'Status'"
                />

                
          
            </div>

                <FeatureFields  v-model:features="form.features"  :adType="adTypes.find(type => type.id === form.ad_type_id)?.slug||null" />

             <!-- attributes -->
              
              <AdAttributes v-model:attributes="form.attributes" />
             <!-- media  -->
              <MediaUploader label="Ad Images" v-model="form.images" type="image" multiple accept="image/*" @deleted="handleMediaDeleted" />

                <MediaUploader label="Ad Video" v-model="form.video" type="video" accept="video/*" @deleted="handleMediaDeleted" />

            <div class="mt-4 flex justify-between">
                <!-- <button type="button" @click="prevStep" v-if="step === 2" class="rounded bg-gray-300 px-4 py-2">Back</button> -->
                <div class="ml-auto flex space-x-2">
                    <button  type="submit" class="rounded bg-green-600 px-4 py-2 text-white">
                         Update
                    </button>
                </div>
            </div>
        </form>
    </AppLayout>

    

</template>
