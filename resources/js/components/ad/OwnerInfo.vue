<template>
  <div class="flex gap-4 items-center">
    <!-- Phone -->
    <a v-if="user.phone" :href="`tel:${user.phone}`" title="Call Phone">
      <PhoneIcon class="w-6 h-6 text-green-600 hover:text-green-800" />
    </a>

    <!-- WhatsApp -->
    <a
      v-if="user.whatsapp"
      :href="`https://wa.me/${formatPhone(user.whatsapp)}`"
      target="_blank"
      title="Chat on WhatsApp"
    >
      <MessageCircleIcon class="w-6 h-6 text-green-500 hover:text-green-700" />
    </a>

    <!-- Location -->
    <a
      v-if="user.latitude && user.longitude"
      :href="`https://www.google.com/maps?q=${user.latitude},${user.longitude}`"
      target="_blank"
      title="View Location"
    >
      <MapPinIcon class="w-6 h-6 text-blue-600 hover:text-blue-800" />
    </a>

    <!-- More Info -->
    <button v-if="showMore" @click="openModal" title="More about the Account">
      <InfoIcon class="w-6 h-6 text-gray-600 hover:text-gray-800" />
    </button>

    <!-- Modal -->
    <div
      v-if="modalVisible && showMore"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg relative overflow-y-auto max-h-[90vh]">
        <button
          @click="modalVisible = false"
          class="absolute top-2 right-3 text-xl text-gray-500 hover:text-red-600"
        >
          &times;
        </button>
        <h2 class="text-lg font-semibold mb-4">Account Information</h2>

        <div class="space-y-2 text-sm">
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Email:</strong> {{ user.email }}</p>
          <p><strong>Phone:</strong> {{ user.phone || 'N/A' }}</p>
          <p><strong>WhatsApp:</strong> {{ user.whatsapp || 'N/A' }}</p>
          <p><strong>Address:</strong> {{ user.address || 'N/A' }}</p>
          <p><strong>Country ID:</strong> {{ user.country_id }}</p>
          <p><strong>City ID:</strong> {{ user.city_id }}</p>
          <p><strong>Latitude:</strong> {{ user.latitude || 'N/A' }}</p>
          <p><strong>Longitude:</strong> {{ user.longitude || 'N/A' }}</p>
          <p><strong>Facebook:</strong> <a v-if="user.facebook" :href="user.facebook" target="_blank" class="text-blue-600 underline">Visit</a></p>
          <p><strong>Instagram:</strong> <a v-if="user.instagram" :href="user.instagram" target="_blank" class="text-pink-500 underline">Visit</a></p>
        </div>

        <!-- Company Info -->
        <div v-if="user.company" class="mt-6 border-t pt-4">
          <h3 class="text-md font-semibold mb-2">Company Information</h3>
          <div class="space-y-2 text-sm">
            <p><strong>Company Name:</strong> {{ user.company.name }}</p>
            <p><strong>Industry:</strong> {{ user.company.industry }}</p>
            <p><strong>Description:</strong> {{ user.company.description }}</p>
            <p><strong>Website:</strong> <a v-if="user.company.website" :href="user.company.website" class="text-blue-600 underline" target="_blank">Visit</a></p>
            <p><strong>Tax ID:</strong> {{ user.company.tax_id }}</p>
            <p><strong>Registration #:</strong> {{ user.company.registration_number }}</p>
            <p><strong>Verified:</strong> {{ user.company.is_verified ? 'Yes' : 'No' }}</p>
            <p><strong>Active:</strong> {{ user.company.is_active ? 'Yes' : 'No' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { PhoneIcon, MessageCircleIcon, MapPinIcon, InfoIcon } from 'lucide-vue-next'
import { User as userType } from '@/types'

const props = defineProps<{
  user: userType
  showMore?: boolean
}>()


const modalVisible = ref(false)

function openModal() {
  modalVisible.value = true
}

function formatPhone(phone:string) {
  return phone.replace(/\D/g, '')
}
</script>
