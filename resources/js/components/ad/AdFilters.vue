<template>
  <div class="mb-6 grid grid-cols-1 gap-4 px-2 py-2 md:grid-cols-6">
    
    <select v-model="localFilters.ad_type_id" :class="[localFilters.ad_type_id ? 'border-green-400' : '', 'rounded border p-2']">
      <option value="">All Types</option>
      <option v-for="type in adTypes" :key="type.id" :value="type.id">
        {{ type.name_en }}
      </option>
    </select>

    <select v-model="localFilters.category_id" :class="[localFilters.category_id ? 'border-green-400' : '', 'rounded border p-2']">
      <option value="">All Categories</option>
      <option v-for="cat in categories" :key="cat.id" :value="cat.id">
        {{ cat.name_en }}
      </option>
    </select>

    <select :disabled="!filteredSubCategories.length" v-model="localFilters.subcategory_id" :class="[localFilters.subcategory_id ? 'border-green-400' : '', 'rounded border p-2']">
      <option value="">All Subcategories</option>
      <option v-for="cat in filteredSubCategories" :key="cat.id" :value="cat.id">
        {{ cat.name_en }}
      </option>
    </select>

    <select v-model="localFilters.brand_id" :class="[localFilters.brand_id ? 'border-green-400' : '', 'rounded border p-2']">
      <option value="">All Brands</option>
      <option v-for="brand in filterdBrands" :key="brand.id" :value="brand.id">
        {{ brand.name_en }}
      </option>
    </select>

    <select v-model="localFilters.model_id" :class="[localFilters.model_id ? 'border-green-400' : '', 'rounded border p-2']">
      <option value="">All Models</option>
      <option v-for="model in filterdModels" :key="model.id" :value="model.id">
        {{ model.name_en }}
      </option>
    </select>

    <div class="flex justify-between items-center">
      <button class="bg-primary text-primary-foreground hover:bg-primary/90 p-1 rounded-lg" @click="applyFilter">Filter</button>
      <button class="bg-destructive text-white hover:bg-destructive/90 p-1 rounded-lg" @click="clear">Clear</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, defineEmits } from 'vue'
import { AdFilter,Category,SubCategory,Brand,BrandModel, AdType } from '@/types'

const props = defineProps<{
  filters: AdFilter
  adTypes:AdType[]
  categories: Category[]
  filteredSubCategories: SubCategory[]
  filterdBrands: Brand[]
  filterdModels: BrandModel[]
}>()

const emit = defineEmits(['update:filters', 'filtering', 'clearFilter'])

const localFilters = ref({ ...props.filters })

// Sync filters with parent on change
watch(localFilters, (val) => {
  emit('update:filters', val)
}, { deep: true })

const applyFilter = () => emit('filtering')
const clear = () => emit('clearFilter')
</script>
