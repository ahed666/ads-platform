<template v-if="breadcrumbs && breadcrumbs.length > 0">
  <div class="bg-gray-50 border-b border-gray-200 py-3 px-4 text-sm">
    <!-- <nav class="container mx-auto flex items-center space-x-2 text-gray-600">
      <template v-for="(item, i) in breadcrumbs" :key="i">
        <RouterLink :to="item.href" class="hover:text-blue-600">{{ item.title }}</RouterLink>
        <span v-if="i < breadcrumbs.length - 1">/</span>
      </template>
    </nav> -->
   
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
  
  </div>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '@/types'
import Breadcrumbs from '@/components/Breadcrumbs.vue';

defineProps<{ breadcrumbs: BreadcrumbItem[] }>()
</script>
