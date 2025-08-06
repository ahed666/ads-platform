<template>
    
    <div
        :class="[
            ad.status === 'active' ? 'opacity-100' : 'opacity-50',
            'borderborder-gray-200 rounded-xl bg-white shadow-sm transition-all duration-200 hover:shadow-md',
        ]"
    >
        <!-- Image Preview -->

        <div class="relative h-40 w-full bg-gray-100">
            <img v-if="ad.images.length" :src="getImage(ad.images[0].url)" alt="Ad Image" class="h-full w-full object-cover" />
            <div v-else class="flex h-full w-full items-center justify-center text-sm text-gray-400">No Image</div>
            <div class="absolute flex justify-between items-center space-x-1 bottom-2 left-2">
              <!-- status tag -->
              <span v-if="ad.purpose" class=" rounded bg-blue-600 px-2 py-0.5 text-xs font-semibold text-white">
                  {{ ad.purpose === 'for_sale' ? 'For Sale' : 'For Rent' }}
              </span>
              <!-- Availability Tag -->
              <span
                  v-if="ad.availability"
                  class=" rounded px-2 py-0.5 text-xs font-semibold text-white"
                  :class="{
                      'bg-green-600': ad.availability === 'available',
                      'bg-red-600': ad.availability === 'sold',
                      'bg-yellow-500': ad.availability === 'rented',
                  }"
              >
                  {{ ad.availability.charAt(0).toUpperCase() + ad.availability.slice(1) }}
              </span>
            </div>
        </div>

        <!-- Ad Details -->
        <div class="space-y-1 p-4 text-sm">
            <div class="truncate font-semibold text-gray-800">
                {{ ad.name_en }}
            </div>
            <div class="text-gray-500">
                {{ ad.AdType?.name_en || '' }}
                <span v-if="ad.category"> / {{ ad.category.name_en }}</span>
                <span v-if="ad.brand"> / {{ ad.brand.name_en }}</span>
            </div>
            <div class="line-clamp-2 text-gray-600">
                {{ ad.description_en || 'No description available' }}
            </div>
            <div class="mt-2 flex items-center justify-between">
                <span class="font-bold text-blue-600">${{ ad.price }} </span>
                <!-- Admin Action Buttons -->
                <div v-if="role==='admin'" class="flex gap-2">
                    <Link :href="`ads/${ad.id}/edit`" class="rounded bg-primary text-primary-foreground hover:bg-primary/90 px-2 py-1 text-xs text-white hover:bg-yellow-500">
                        Edit
                    </Link>
                    <button @click="$emit('delete', ad.id)" class="rounded bg-red-500 px-2 py-1 text-xs text-white hover:bg-red-600">
                        Delete
                    </button>
                </div>
               
                <div v-else-if="ad.user">
                     <!-- {{ ad.company.name }} -->
                       <Link :href="`/ads/${ad.id}`" >view</Link>
                </div>
                 
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Ad,AdPageProps } from '@/types';
import { Link,usePage } from '@inertiajs/vue3';


const page = usePage<AdPageProps >();
const {role } = page.props.auth;

defineProps<{
    ad: Ad;
}>();

defineEmits<{
    (e: 'delete', id: number): void;
}>();

const getImage = (url: string | null) => `${url}`;
</script>
