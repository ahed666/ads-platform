<template>
  <div>
    <div v-if="ads.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <AdCard
        v-for="ad in ads"
        :key="ad.id"
        :ad="ad"
      />
    </div>

    <div v-else class="text-center py-10 text-gray-500">
      No ads found.
    </div>
  </div>
</template>

<script setup lang="ts">
import AdCard from './AdCard.vue'
import type { Ad } from '@/types'

const props = defineProps<{
  ads: Ad[]
}>()
</script>
