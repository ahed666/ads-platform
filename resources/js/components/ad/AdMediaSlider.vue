<template>
  <div class="w-full space-y-4">
    <!-- ✅ Main Media Viewer -->
    <div @click="openGallery(activeIndex)" class="cursor-pointer group relative">
      <component
        :is="currentMedia.type === 'video' ? 'video' : 'img'"
        :src="currentMedia.url"
        :controls="currentMedia.type === 'video'"
        muted
        playsinline
        preload="metadata"
        class="w-full h-72 sm:h-96 md:h-[28rem] object-cover rounded-xl transition duration-300 group-hover:scale-[1.01]"
      />
      <div v-if="currentMedia.type === 'video'" class="absolute inset-0 bg-black/30 flex items-center justify-center pointer-events-none">
        <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 24 24">
          <path d="M8 5v14l11-7z" />
        </svg>
      </div>
    </div>

    <!-- ✅ Thumbnails -->
    <div class="flex gap-3 overflow-x-auto">
      <div
        v-for="(media, index) in allMedia"
        :key="index"
        class="relative flex-shrink-0 border-2 rounded-lg overflow-hidden cursor-pointer"
        :class="index === activeIndex ? 'border-blue-600' : 'border-transparent'"
        @click="activeIndex = index"
      >
        <img
          loading="lazy"
          v-if="media.type === 'image'"
          :src="media.url"
          class="w-20 h-16 object-cover"
        />
        <div v-else class="relative w-20 h-16 bg-black">
          <video :src="media.url" muted class="w-full h-full object-cover" />
          <div class="absolute inset-0 flex items-center justify-center bg-black/40">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/style.css'

import { Image, Video } from '@/types'

const props = defineProps<{
  images: Image[]
  video?: Video | null
}>()

type MediaSlide =
  | { src: string; width: number; height: number }
  | { html: string };
// 🧠 Combine images + video into unified media array
const allMedia = computed(() => {
  const media = props.images.map(img => ({ type: 'image', url: img.url }))
  if (props.video?.url) {
    media.push({ type: 'video', url: props.video.url })
  }
  return media
})

const activeIndex = ref(0)

const currentMedia = computed(() => allMedia.value[activeIndex.value])

const slides = (): MediaSlide[] =>
  allMedia.value.map((media) => {
    if (media.type === 'image' && media.url) {
      return {
        src: media.url,
        width: 1600,
        height: 1200
      }
    }

    if (media.type === 'video' && media.url) {
      return {
        html: `<div style="max-width:100%; max-height:100%; display:flex; align-items:center; justify-content:center; background:#000;">
    <video 
      src="${media.url}" 
      controls 
      style="max-width:100%; max-height:100%; border-radius: 8px;" 
      preload="metadata"
      playsinline
    ></video>
  </div>`
      }
    }

   
    return {
      src: '',
      width: 800,
      height: 600
    }
  })

// ✅ Open PhotoSwipe Gallery
const openGallery = (index: number) => {
   
 const lightbox = new PhotoSwipeLightbox({
  dataSource: slides(), 
  pswpModule: () => import('photoswipe'),
})

lightbox.init()
lightbox.loadAndOpen(index)
}
</script>
