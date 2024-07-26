<script setup>
import ArrowLeft from "@/Icons/ArrowLeftIcon.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

import Sidebar from "../Components/Sidebar.vue";
import ToastList from "../Components/ToastList.vue";
import InfoIcon from "../Icons/InfoIcon.vue";
defineProps({
    title: String,
    name: String,
    showInfo: Boolean,
    infoLink: String,
});

const goBack = () => {
    window.history.back();
}

</script>

<template>
    <div class="min-h-screen max-h-screen flex flex-col bg-white overflow-hidden">

        <ToastList />

        <Head :title="title" />

        <div class="bg-gray-100 flex flex-col flex-1">
            <nav class="bg-white border-b border-gray-100 fixed w-full z-10">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <button @click="goBack()">
                                    <ArrowLeft />
                                </button>
                            </div>
                        </div>
                        <div class="flex">
                            <p>{{ name }}</p>
                        </div>

                        <div class="flex">
                            <Link v-if="showInfo" :href="infoLink">
                            <InfoIcon />
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex">
                <!-- sidebar  -->
                <Sidebar />
                <!-- Page Content -->
                <main class="bg-gray-100 md:ml-[20rem] lg:ml-[0rem] m-auto mt-[5rem] mb-[5rem] w-full">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
