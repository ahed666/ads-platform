<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import type { Ad} from '@/types';
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import AdOverview from '@/components/ad/AdOverview.vue';

const props = defineProps<{
   
    ad: Ad;
   
}>();
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Home',
    href: `/`,
  },{
    title: 'View Ad',
    href: `/ads/${props.ad.id}`,
  },

];





</script>
<template>
   

    <WebsiteLayout :breadcrumbs="breadcrumbs">
      
       <AdOverview :ad="ad" />
    </WebsiteLayout>

    

</template>
