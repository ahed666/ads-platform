<script setup lang="ts">
import WebsiteFooter from '@/components/website/WebsiteFooter.vue';
import WebsiteHeader from '@/components/website/WebsiteHeader.vue';
import WebsiteNavbar from '@/components/website/WebsiteNavbar.vue';
import type {  BreadcrumbItemType } from '@/types';
import Breadcrumbs from '@/components/Breadcrumbs.vue';


interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>
<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
   
   <WebsiteNavbar/>
   

   <WebsiteHeader v-if="breadcrumbs?.length" :breadcrumbs="breadcrumbs" />

    <!-- Page Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
      <slot />
    </main>

    <!-- Footer -->
    <WebsiteFooter />
  </div>
</template>


