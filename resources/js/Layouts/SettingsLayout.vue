<script setup>
import Banner from "@/Components/Banner.vue";
import { Head } from "@inertiajs/inertia-vue3";

import BottomTab from "../Components/BottomTab.vue";
import Sidebar from "../Components/Sidebar.vue";
import ToastList from "../Components/ToastList.vue";

defineProps({
  title: String,
});


</script>

<template>
  <div class="max-h-screen">

    <ToastList />
    
    <Head :title="title" />

    <Banner />

    <div class="bg-gray-100">
      <div class="flex max-w-7xl mx-auto">
        <!-- component -->
        <Sidebar />
        <!-- Page Content -->
        <main :class="`bg-gray-100 min-h-screen md:ml-[20rem] mb-[5rem] w-full`">
          <slot />
        </main>
      </div>
    </div>
    <!-- tab navigation  -->
    <BottomTab />
  </div>
</template>
