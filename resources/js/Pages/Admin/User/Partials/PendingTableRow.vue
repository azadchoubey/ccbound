
<script setup>
import BinIcon from '@/Icons/BinIcon.vue';
import EditIcon from '@/Icons/EditIcon.vue';
import EllipsisHorizontal from '@/Icons/EllipsisHorizontal.vue';
import EyeIcon from '@/Icons/EyeIcon.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, onUnmounted, ref } from 'vue';

const showDropDown = ref(false)

const closeOnEscape = (e) => {
    if (showDropDown.value && e.key === 'Escape') {
        showDropDown.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
</script>
<template>
    <div v-show="showDropDown" class="fixed inset-0 z-40" @click="showDropDown = false" />
    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                1/12/2023
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold" :href="`/organizations/asdf/edit`">
                Rakesh
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                rakesh@gmail.com
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                3125649870
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                <p class="bg-yellow-200 text-yellow-600 text-sm px-2 rounded-xl">pending</p>
            </p>
        </td>
        <td class="border-t relative flex flex-col justify-center items-center pt-2.5">
            <button @click="showDropDown = !showDropDown">
                <EllipsisHorizontal />
            </button>
            <div v-if="showDropDown" class="absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem]">
                <a :href="route('profile')" target="_blank" class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200">
                    <EyeIcon class="h-[1rem]" />
                    <p>View</p> 
                </a>
                <Link class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold">
                    <BinIcon class="h-[1rem]" />
                    <p>Deactivate</p>
                </Link>
            </div>
        </td>
    </tr>
</template>