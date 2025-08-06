<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { AdType, type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import type { AdFilter,Auth, Brand, BrandModel, Category, Pagination, Ad, SubCategory } from '@/types';
import { computed, ref, watch } from 'vue';
// import CreateAdModal from '@/pages/ads/CreateAdModal.vue'
import AdCard from '@/components/ad/AdCard.vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';

import AdFilters from '@/components/ad/AdFilters.vue';

const props = defineProps<{
    ads: Pagination<Ad>;
    adTypes:AdType[];
    categories:Category[];
    auth:Auth,
    brands:Brand[],
    models:BrandModel[],
    subCategories:SubCategory[],
    filters:AdFilter,

}>();

const adsList = ref<Ad[]>(props.ads?.data ? [...props.ads.data] : []);

// const page = usePage<AdPageProps >();
// const {  permissions } = page.props.auth;


const {  permissions } =props.auth;

const adTypes=ref<AdType[]>(props.adTypes)
const categories = ref<Category[]>(props.categories);
const brands = ref<Brand[]>(props.brands);
const models = ref<BrandModel[]>(props.models);
const subCategories = ref<SubCategory[]>(props.subCategories);
// const adForEdit=ref<Ad>()

// filters
const filters = ref({
    ad_type_id:props.filters?.ad_type_id||'',
    category_id: props.filters?.category_id || '',
    subcategory_id: props.filters?.subcategory_id || '',
    brand_id: props.filters?.brand_id || '',
    model_id: props.filters?.model_id || '',
});

const filteredCategories = computed(() => {
    if (!filters.value.ad_type_id) return [];
    return categories.value.filter((cat) => cat.ad_type_id == filters.value.ad_type_id);
});
const filteredSubCategories = computed(() => {
    if (!filters.value.category_id) return [];
    return subCategories.value.filter((sub) => sub.category_id == filters.value.category_id);
});
const filterdBrands = computed(() => {
    if (!filters.value.subcategory_id) return [];
    return brands.value.filter((brand) => brand.ad_type_id == filters.value.ad_type_id);
});
const filterdModels = computed(() => {
    if (!filters.value.brand_id) return [];
    return models.value.filter((model) => model.brand_id == filters.value.brand_id);
});
const filtering = () => {
    router.get('/dashboard/ads', filters.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

const clearFilter = ()=>{
  filters.value.category_id=''
  filters.value.subcategory_id=''
  filters.value.brand_id=''
  filters.value.model_id=''
  router.visit('/ads')
}

// const showCreateModal = ref(false)

async function confirmDelete(id: number) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    });

    if (result.isConfirmed) {
        try {
            console.log('delete:', id);
           const response= await axios.delete(`/dashboard/ads/${id}`);
           console.log('ad deleted',response); 
           toast.success('Ad deleted ✅');
            router.visit('/dashboard/ads', {
                preserveState: true,
                preserveScroll: true,
                only: ['ads'],
            });
        } catch (error) {
            toast.error('Failed to delete ad ❌('+error+')');
        }
    }
}




watch(
  () => props.ads,
  (newAds) => {
    adsList.value = [...newAds.data];
  },
  { immediate: true }
);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ads',
        href: '/ads',
    },
];

const goToPage = (url: string) => {
    router.visit(url);
};
</script>

<template>
    <Head title="Ads" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mb-4 px-2 py-2  flex items-center justify-between">
                
            <Link v-if="permissions.includes('manage ads')" href="ads/create" class="bg-primary text-primary-foreground hover:bg-primary/90 p-1 rounded-lg"> Add Ad </Link>
            <h1 class="text-primary text-md"><span class="text-lg font-bold">{{ adsList.length }}</span> Ads</h1>
        </div>
        
        <!-- filtering -->
         <AdFilters
          v-model:filters="filters"
          :adTypes="adTypes"
          :categories="filteredCategories"
          :filteredSubCategories="filteredSubCategories"
          :filterdBrands="filterdBrands"
          :filterdModels="filterdModels"
          @filtering="filtering"
          @clearFilter="clearFilter"
        />

        

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div v-if="props.ads && props.ads.data.length" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="ad in adsList" :key="ad.id">
                    <AdCard  @delete="confirmDelete" :ad="ad" />
                </div>
            </div>

            <div class="mt-4 flex justify-center space-x-1">
                <template v-for="link in ads.meta.links" :key="link.label">
                    <button
                        v-if="link.url"
                        v-html="link.label"
                        @click="goToPage(link.url)"
                        :class="['rounded border px-3 py-1', link.active ? 'bg-blue-500 text-white' : 'bg-white text-black hover:bg-gray-200']"
                    />
                    <span v-else v-html="link.label" class="px-3 py-1 text-gray-400" />
                </template>
            </div>
        </div>
    </AppLayout>

    <!-- <CreateAdModal
        :ad="adForEdit"
        :show="showCreateModal"
         @close="showCreateModal = false"
          @saved="onAdAction"
           :categories="categories"
           :subCategories="subCategories"
      :brands="brands"
      :models="models" /> -->
</template>
