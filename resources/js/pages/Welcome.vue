<script setup lang="ts">
import { Head, Link ,router, usePage} from '@inertiajs/vue3';
import AdCard from '@/components/ad/AdCard.vue';
import {Ad,AdPageProps} from '@/types';
import { ref } from 'vue';
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';

// const goToPage = (url: string) => {
//     router.visit(url);
// };
const page = usePage<AdPageProps >();
const props = defineProps<{
    ads: Ad[];
}>();
const adsList = ref<Ad[]>(props.ads ? [...props.ads] : []);

// watch(
//     () => page.props.ads as Pagination<Ad>,
//     (newAds: Pagination<Ad>) => {
//         adsList.value = [...newAds.data];
//     },
// );

</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
   <Head title="Welcome" />

  <WebsiteLayout >
    <!-- Auth Navigation -->
    <div class="mb-6 flex justify-end gap-4 text-sm">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="rounded border border-gray-300 px-4 py-1.5 hover:bg-gray-100"
      >
        Dashboard
      </Link>
      <template v-else>
        
      </template>
    </div>

    <!-- Ads Grid -->
    <section>
      <h1 class="text-2xl font-bold mb-4">Available Machines</h1>

      <div v-if="adsList.length" class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <AdCard v-for="ad in adsList" :key="ad.id" :ad="ad" />
      </div>

      <div v-else class="text-gray-500 text-center mt-8">
        No ads found.
      </div>
    </section>
  </WebsiteLayout>
</template>
