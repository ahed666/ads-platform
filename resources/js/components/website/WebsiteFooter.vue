<script setup lang="ts">
import { Link,usePage } from '@inertiajs/vue3';
const appName = usePage().props.appName as string;

</script>
<template>
  <footer class="bg-gray-100 border-t border-gray-200 py-6 text-center text-sm text-gray-500">
    © {{ new Date().getFullYear() }} {{ appName }}. All rights reserved.
  </footer>
</template>
