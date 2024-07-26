<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Notifications">
        <div class="px-2 max-w-[40rem]">
            <p class="text-xl font-bold">Notifications</p>
            <div class="w-full p-3 mt-4 bg-white rounded shadow flex flex-shrink-0">
                <div class="pl-3 w-full">
                    <div class="flex items-center justify-between w-full">
                        <p class="focus:outline-none text-sm leading-none"><span class="text-indigo-700">Kishore</span>
                            signuped using your referal link</p>
                    </div>
                    <p tabindex="0" class="focus:outline-none text-xs leading-3 pt-1 text-gray-500">2 hours ago</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
