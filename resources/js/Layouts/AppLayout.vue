<script setup>
import Banner from "@/Components/Banner.vue";
import { Head } from "@inertiajs/inertia-vue3";

import BottomTab from "../Components/BottomTab.vue";
import Sidebar from "../Components/Sidebar.vue";
import ToastList from "../Components/ToastList.vue";

defineProps({
  title: String,
});

const goBack = () => {
    window.history.back();
}
</script>

<template>
  <div class="max-h-screen">

    <ToastList />
    
    <Head :title="title" />

    <Banner />

    <div class="bg-gray-100">
      <div class="flex max-w-7xl mx-auto">
        <!-- sidebar -->
        <Sidebar />
        <!-- Page Content -->
        <main :class="`bg-gray-100 md:ml-[20rem] mb-[5rem] w-full`">
          <slot />
        </main>
      </div>
    </div>
    <!-- tab navigation  -->
    <BottomTab />
  </div>
</template>
