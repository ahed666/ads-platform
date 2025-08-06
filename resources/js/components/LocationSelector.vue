<template>
  <div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Country -->
      <div>
        <label class="block text-sm font-medium mb-1 text-gray-700">Country</label>
        <select
          v-model="localValue.country_id"
          class="w-full rounded border-gray-300 text-sm shadow-sm focus:ring focus:ring-blue-200"
          @change="onCountryChange"
        >
          <option disabled value="">Select Country</option>
          <option v-for="country in countries" :key="country.id" :value="country.id">
            {{ country.name_en }}
          </option>
        </select>
      </div>

      <!-- City -->
      <div>
        <label class="block text-sm font-medium mb-1 text-gray-700">City</label>
        <select
          v-model="localValue.city_id"
          class="w-full rounded border-gray-300 text-sm shadow-sm focus:ring focus:ring-blue-200"
        >
          <option disabled value="">Select City</option>
          <option
            v-for="city in filteredCities"
            :key="city.id"
            :value="city.id"
          >
            {{ city.name_en }}
          </option>
        </select>
      </div>
    </div>

    <!-- Address -->
    <BaseInput
      v-model="localValue.address"
      label="Address"
      placeholder="Street, Building, etc."
    />

    <!-- Map -->
    <div>
      <label class="block text-sm font-medium mb-1 text-gray-700">Select Location on Map</label>
      <div id="location-map" class="h-64 w-full rounded border"></div>
      <p class="text-sm text-gray-500 mt-2">
        Coordinates: {{ localValue.latitude ?? 'Not set' }}, {{ localValue.longitude ?? 'Not set' }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted, nextTick } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import type { Country, City } from '@/types'
import BaseInput from '@/components/BaseInput.vue'

const props = defineProps<{
  modelValue: {
    country_id: number | null
    city_id: number | null
    address: string | null
    latitude: number | null
    longitude: number | null
  }
  countries: Country[]
  cities: City[]
}>()

const emit = defineEmits(['update:modelValue'])

const localValue = ref({ ...props.modelValue })

watch(
  () => props.modelValue,
  (val) => {
    localValue.value = { ...val }
  }
)

watch(localValue, () => {
  emit('update:modelValue', { ...localValue.value })
}, { deep: true })

const filteredCities = computed(() =>
  props.cities.filter((c) => c.country_id === localValue.value.country_id)
)

let map: any
let marker: any

function initMap() {
  map = L.map('location-map').setView(
    [localValue.value.latitude || 25.276987, localValue.value.longitude || 55.296249], // دبي افتراضيًا
    8
  )

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
  }).addTo(map)

  if (localValue.value.latitude && localValue.value.longitude) {
    marker = L.marker([localValue.value.latitude, localValue.value.longitude]).addTo(map)
  }

  map.on('click', (e: any) => {
    const { lat, lng } = e.latlng
    localValue.value.latitude = lat
    localValue.value.longitude = lng

    if (marker) {
      marker.setLatLng(e.latlng)
    } else {
      marker = L.marker(e.latlng).addTo(map)
    }
  })
}

function onCountryChange() {
  localValue.value.city_id = null
}

onMounted(() => {
  nextTick(() => {
    initMap()
  })
})
</script>
