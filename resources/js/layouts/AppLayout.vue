<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type {  BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const { user, role, permissions } = page.props.auth;

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
   
    
    <AppLayout v-if="role==='admin'" :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
    <div v-else-if="role==='super_admin'">
        super admin

    </div>
</template>
