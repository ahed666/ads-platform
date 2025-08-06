<template>
  <div
    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row"
  >
    <!-- Left: Media Slider -->
    <div class="md:w-1/2 w-full relative bg-gray-100">
      <AdMediaSlider
        :images="ad.images"
        :video="ad.video"
        :alt="ad.name_en"
      />
      <!-- 🔖 Status Badge -->
      <span
        class="absolute top-3 left-3 text-xs font-semibold px-3 py-1 rounded-full bg-white/90 backdrop-blur border"
        :class="statusColor"
      >
        {{ statusLabel }}
      </span>
    </div>

    <!-- Right: Ad Info -->
    <div class="md:w-1/2 w-full p-6 space-y-4">
      <!-- Title -->
      <h2 class="text-lg font-bold text-gray-900 truncate">{{ ad.name_en }}</h2>

      <!-- Meta Info -->
      <div class="flex flex-wrap gap-3 text-sm text-gray-600">
        <div>Category: <span class="font-medium text-gray-800">{{ ad.category?.name_en }}</span></div>
        <div>Model: <span class="font-medium text-gray-800">{{ ad.model?.name_en }}</span></div>
        <div>Brand: <span class="font-medium text-gray-800">{{ ad.brand?.name_en }}</span></div>
      </div>

      <!-- Price -->
      <div class="text-xl font-extrabold text-blue-600">{{ formattedPrice }}</div>

      <!-- Features -->
      <div
        v-if="ad.features && Object.keys(ad.features).length"
        class="bg-gray-50 rounded-lg p-3 text-sm text-gray-700 border"
      >
        <h4 class="font-semibold text-gray-800 mb-1">🔧 Features</h4>
        <ul class="grid grid-cols-2 gap-2">
          <li v-for="(value, key) in ad.features" :key="key">
            <span class="font-medium capitalize">{{ key }}:</span> {{ value }}
          </li>
        </ul>
      </div>

      <!-- Attributes -->
      <div
        v-if="ad.attributes && ad.attributes.length"
        class="border-t pt-3 text-sm text-gray-700"
      >
        <h4 class="font-semibold text-gray-800 mb-1">📌 Attributes</h4>
        <ul class="grid grid-cols-2 gap-2">
          <li v-for="(attr, i) in ad.attributes" :key="i" class="truncate">
            <span class="font-medium">{{ attr.value.label_en }}/{{ attr.value.label_ar }}:</span>
            {{ attr.value.value }}
          </li>
        </ul>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-between items-center pt-4 border-t mt-2">
        <button class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition-all">
          View Details
        </button>
        <OwnerInfo :user="ad.user" :show-more="true" />
         
      </div>
    </div>
  </div>
</template>


<script lang="ts" setup>
import { computed,watchEffect  } from 'vue'
import {Ad,AdSEO} from '@/types'
import AdMediaSlider from './AdMediaSlider.vue';
import OwnerInfo from './OwnerInfo.vue';
const props = defineProps<{
  ad: Ad,
  // seo:AdSEO,
}>()
// watchEffect(() => {
//   const seo = props.seo || {}

//   document.title = seo.title || 'Default Title'

//   const updateMeta = (nameOrProperty:string, content:string, isProperty:boolean = false) => {
//     if (!content) return
//     const selector = isProperty ? `meta[property="${nameOrProperty}"]` : `meta[name="${nameOrProperty}"]`
//     let tag = document.querySelector(selector)
    
//     if (!tag) {
//       tag = document.createElement('meta')
//       if (isProperty) {
//         tag.setAttribute('property', nameOrProperty)
//       } else {
//         tag.setAttribute('name', nameOrProperty)
//       }
//       document.head.appendChild(tag)
//     }
//     tag.setAttribute('content', content)
//   }

//   updateMeta('description', seo.description)
//   updateMeta('keywords', [
//     seo.title,
//     seo.type,
//     seo.category,
//     seo.subcategory,
//     seo.brand,
//     seo.model
//   ].filter(Boolean).join(', '))

//   updateMeta('og:title', seo.title, true)
//   updateMeta('og:description', seo.description, true)
//   updateMeta('og:type', 'ad', true)
// })


const formattedPrice = computed(() =>
  new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    maximumFractionDigits: 0
  }).format(props.ad.price??0)
)

const statusLabel = computed(() => {
  switch (props.ad.status) {
    case 'for_sale':
      return 'For Sale'
    case 'for_rent':
      return 'For Rent'
    case 'sold':
      return 'Sold'
    default:
      return ''
  }
})

const statusColor = computed(() => {
  switch (props.ad.status) {
    case 'for_sale':
      return 'bg-green-600 text-white'
    case 'for_rent':
      return 'bg-yellow-500 text-white'
    case 'sold':
      return 'bg-red-500 text-white'
    default:
      return 'bg-gray-400 text-white'
  }
})
</script>
