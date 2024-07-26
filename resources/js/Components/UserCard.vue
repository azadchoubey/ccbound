<script setup>
import BuildingIcon from '../Icons/BuildingIcon.vue';
import UserIcon from '../Icons/UserIcon.vue';
import { ref } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import EyeIcon from '../Icons/EyeIcon.vue';
defineProps({
    profile_image:String,
    name:String,
    companyName: String,
    last_message:String
});

const readMore = ref(false);
</script>

<template>
    <div class="bg-white p-2 flex items-center gap-1">
        <img :src=profile_image alt="profile image" class="h-[3rem] w-[3rem]">
        <div>
            <p>Benzene - {{ name }} / {{ companyName }}</p>
            <p class="text-xs">{{ last_message.slice(0,50) }}...</p>
        </div>
    </div>
</template>