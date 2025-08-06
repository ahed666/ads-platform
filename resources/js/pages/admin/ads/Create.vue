<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import axios from 'axios';
import { computed, ref } from 'vue';
import type { Brand,AdType, BrandModel, Category, AdForm, SubCategory } from '@/types';
import { router } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import BaseSelect from '@/components/BaseSelect.vue';
import MediaUploader from '@/components/MediaUploader.vue';
import FeatureFields from '@/components/ad/features/FeatureFields.vue';

import AdAttributes from '@/components/ad/AdAttributes.vue';
import AdBasicInfo from '@/components/ad/AdBasicInfo.vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Ads', href: '/dashboard/ads' },
    {
        title: 'Create Ad',
        href: '',
    },
];
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

const props = defineProps<{
    adTypes: AdType[];
    categories: Category[];
    brands: Brand[];
    models: BrandModel[];
    subCategories: SubCategory[];
}>();

const form = ref<AdForm>({
   
  ad_type_id: null,
  category_id: null,
  subcategory_id: null,
  brand_id: null,
  model_id: null,
  name_en: '',
  name_ar: '',
  description_en: '',
  description_ar: '',
  price: 0,
  images: [], // type must be Image[] or null
  video: null,
  purpose: '',
  status: '',
  availability: '',
  features: {},         // assuming FeatureSet is an object
  attributes: [],       // assuming it's an array of AttributeItem
});






const deletedMedia=ref<number[]>([])
const isSubmitting = ref(false);

function handleMediaDeleted(id: number) {
    if (!deletedMedia.value.includes(id)) {
        deletedMedia.value.push(id);
    }
}

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


async function submit() {
   isSubmitting.value = true;
   
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
         if (form.value.ad_type_id) formData.append('ad_type_id', form.value.ad_type_id.toString());
        if (form.value.category_id) formData.append('category_id', form.value.category_id.toString());
        if (form.value.subcategory_id) formData.append('subcategory_id', form.value.subcategory_id.toString());
        if (form.value.brand_id) formData.append('brand_id', form.value.brand_id.toString());
        if (form.value.model_id) formData.append('model_id', form.value.model_id.toString());

        if (form.value.images && form.value.images.length) {
            form.value.images.forEach((img, idx) => {
                if (img.file) formData.append(`images[${idx}]`, img.file);
            });
        }

        if (form.value.video && form.value.video.file) {
            formData.append('video', form.value.video.file);
        }

        
      

        
            //create ad
           const response = await axios.post('/dashboard/ads', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
        
          toast.success(response.data.message || 'Ad created successfully!');

          router.visit('/dashboard/ads');

       
    } catch (error: any) {
        console.log(error);
            toast.error(error.response?.data || error.message || 'Failed to create ad.');
    }finally {
        isSubmitting.value = false;
    }
}
</script>
<template>
    <Head title="Add Ad" />
   

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <!-- Section 1: Ad Classification -->
            <section class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">1. Ad Classification</h2>
                <div class="grid grid-cols-2 gap-4">
                <BaseSelect v-model="form.ad_type_id" :options="adTypes" valueKey="id" labelKey="name_en" label="Ad Type" required />
                <BaseSelect v-model="form.category_id" :options="filteredCategories" valueKey="id" labelKey="name_en" label="Category" required />
                <BaseSelect v-model="form.subcategory_id" :options="filteredSubcategories" valueKey="id" labelKey="name_en" label="Sub Category" />
                <BaseSelect v-model="form.brand_id" :options="filteredBrands" valueKey="id" labelKey="name_en" label="Brand" />
                <BaseSelect v-model="form.model_id" :options="filteredModels" valueKey="id" labelKey="name_en" label="Model" />
                </div>
            </section>

            <!-- Section 2: Basic Info -->
               <AdBasicInfo
                    v-model:form="form"
                />

            <!-- Section 3: Additional Dropdowns -->
            <section class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">3. Additional Options</h2>
                <div class="grid grid-cols-2 gap-4">
                <BaseSelect v-model="form.purpose" :options="purposesOptions" valueKey="id" labelKey="purpose" label="Purpose" />
                <BaseSelect v-model="form.availability" :options="availabilityOptions" valueKey="id" labelKey="availability" label="Availability" />
                <BaseSelect v-model="form.status" :options="statusOptions" valueKey="id" labelKey="status" label="Status" />
                </div>
            </section>

            <!-- Section 4: Features -->
            <section class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">4. Ad Features</h2>
                <FeatureFields  v-model:features="form.features"  :adType="adTypes.find(type => type.id === form.ad_type_id)?.slug||null" />
            </section>

            <!-- Section 5: Attributes -->
            <section class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">5. Ad Attributes</h2>
                <AdAttributes v-model:attributes="form.attributes" />
            </section>
             <!-- Section 6: Media Upload -->
            <section class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">6. Media Upload</h2>
                <MediaUploader label="Ad Images" v-model="form.images" type="image" multiple accept="image/*" @deleted="handleMediaDeleted" />
                <MediaUploader label="Ad Video" v-model="form.video" type="video" accept="video/*" @deleted="handleMediaDeleted" />
            </section>
            <div class="mt-4 flex justify-between">
                <!-- <button type="button" @click="prevStep" v-if="step === 2" class="rounded bg-gray-300 px-4 py-2">Back</button> -->
                <div class="ml-auto flex space-x-2">
                   <button
                    type="submit"
                    class="rounded bg-green-600 px-4 py-2 text-white disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="isSubmitting"
                    >
                    {{ isSubmitting ? 'Creating...' : 'Create' }}
                    </button>
                </div>
            </div>
        </form>
    </AppLayout>

    

</template>
