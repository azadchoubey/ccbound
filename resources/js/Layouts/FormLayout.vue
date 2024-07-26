<script setup>
import Banner from "@/Components/Banner.vue";
import ArrowLeft from "@/Icons/ArrowLeftIcon.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
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
    <!-- navbar -->
    <div class="md:hidden px-2 py-4 flex border-b border-gray-200">
        <button @click="goBack">
            <ArrowLeft />
        </button>
        <div class="w-full flex justify-center">
           <p class="font-bold text-xl">{{ title }}</p>
        </div>
    </div>
    <div class="md:bg-gray-100 ">
      <div class="flex max-w-7xl mx-auto">
        <!-- Sidebar -->
        <Sidebar />
        <!-- Page Content -->
        <main :class="`bg-gray-100 md:ml-[20rem] mb-[5rem] w-full`">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
