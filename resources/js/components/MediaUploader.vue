<template>
  <div>
    <label class="block text-sm font-medium mb-2">{{ label }}</label>

    
    <label
      :for="inputId"
      class="w-32 h-32 border-2 border-dashed border-gray-400 rounded flex items-center justify-center cursor-pointer hover:bg-gray-100 transition"
    >
      <slot name="icon">
        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0 0l-3-3m3 3l3-3M20 12h-4m-4-4H8m0 0l3-3m-3 3l-3-3" />
        </svg>
      </slot>
      <input
       
        :id="inputId"
        type="file"
        :accept="accept"
        :multiple="multiple"
        class="hidden"
        @change="handleUpload"
      />
    </label>

    
    <div v-if="isImage" class="flex gap-2 mt-4 overflow-x-auto">
      <div
        v-for="(item, index) in modelValue"
        :key="index"
        class="relative w-24 h-24 border rounded overflow-hidden"
      >
        <div v-if="item.loading" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10">
          <span class="text-xs text-gray-600">Uploading...</span>
        </div>
        <img v-if="item.url" :src="item.url" class="w-full h-full object-cover" />
        <button
          type="button"
          @click="remove(index)"
          class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow"
        >
          ×
        </button>
      </div>
    </div>

    
    <div v-if="isVideo && modelValue" class="relative w-full max-w-xs mt-4">
      <div v-if="modelValue.loading" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10">
        <span class="text-sm text-gray-600">Uploading...</span>
      </div>
      <video
        v-if="modelValue.url"
        controls
        :src="modelValue.url"
        class="w-full max-h-48 rounded"
      ></video>
      <button
          type="button"
          @click="remove(index)"
          class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow"
        >
          ×
        </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { v4 as uuid } from 'uuid'
const inputId = `input-${uuid()}`

const props = defineProps<{
  label: string
  modelValue: any
  multiple?: boolean
  accept?: string
  type: 'image' | 'video'
}>()

const emit = defineEmits(['update:modelValue','deleted'])

const isImage = props.type === 'image'
const isVideo = props.type === 'video'

function handleUpload(event: Event) {
  const target = event.target as HTMLInputElement
  const files = target.files
  if (!files || files.length === 0) return

  if (isImage) {
    const newItems = Array.from(files).map(file => ({
      file,
      url: URL.createObjectURL(file),
      loading: false,
    }))

   

    emit('update:modelValue', [...props.modelValue, ...newItems])
    
    
  }

  if (isVideo) {
    const file = files[0]
    emit('update:modelValue', {
      file,
      url: URL.createObjectURL(file),
      loading: false,
    })
  }
}

function remove(index: number) {
  if (isImage) {
    const newImages = [...props.modelValue]
       const removed = newImages.splice(index, 1)[0]
    emit('update:modelValue', newImages)
    
    if (removed.id) {
      emit('deleted', removed.id) 
    }
  }
  else
  {
   const removed = props.modelValue
    emit('update:modelValue', null)
     if (removed?.id) {
      emit('deleted', removed.id) 
    }
  }
  
}
</script>
