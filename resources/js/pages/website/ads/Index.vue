<script setup lang="ts">
import AdList from '@/components/ad/AdList.vue';
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import { type BreadcrumbItem,AdFilter,Ad,Pagination,Category,SubCategory,Brand,BrandModel } from '@/types';
import {ref } from 'vue';
const props=defineProps<{
category:Category|null,
subcategory:SubCategory|null,
brand:Brand|null,
model:BrandModel|null,
categories:Category[],
subCategories:SubCategory[],
brands:Brand[],
brandModel:BrandModel[],
ads: Pagination<Ad>;
filter:AdFilter;

}>();

const adsList = ref<Ad[]>(props.ads?.data ? [...props.ads.data] : []);

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Home',
    href: `/`,
  },{
title: `Ads${props.category ? ' / ' + props.category.name_en : ''}${props.subcategory ? ' / ' + props.subcategory.name_en : ''}`,
     href: `/ads`,
  },

];
</script>
<template>
 <WebsiteLayout :breadcrumbs="breadcrumbs">
     <AdList :ads="adsList" />
 </WebsiteLayout>
</template>