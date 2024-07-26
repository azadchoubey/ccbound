<script setup>
import ArrowLeft from '@/Icons/ArrowLeftIcon.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';


import Sidebar from '../Components/Sidebar.vue';
import ToastList from '../Components/ToastList.vue';
defineProps({
    title: String,
});

const goBack = () => {
    window.history.back();
}
</script>

<template>
    <div class="min-h-screen max-h-screen flex flex-col">

        <ToastList />
        
        <Head :title="title" />

        <div class="bg-gray-100 flex flex-col flex-1">
            <nav class="bg-white border-b border-gray-100 md:hidden">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <button @click="goBack">
                                <ArrowLeft />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex">
                <!-- Sidebar -->
                <Sidebar v-if="$page.props.user.role === 'user' || $page.props.user.role === 'admin'" />
                <!-- Page Content -->
                <main class="max-w-3xl md:ml-[22rem] xl:mx-auto py-[5rem]">
                    <slot />
                </main>
            </div>

        </div>
    </div>

</template>
