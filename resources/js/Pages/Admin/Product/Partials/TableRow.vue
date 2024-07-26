
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
                Bezene
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                125-649-870
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
                <p class="bg-green-200 text-green-600 text-sm px-2 rounded-xl">Approved</p>
            </p>
        </td>
        <td class="border-t relative flex flex-col justify-center items-center pt-2.5">
            <!-- <Link :href="route('profile')" class="flex items-center px-4 hover:underline text-blue-600" tabindex="-1">View</Link> -->
            <button @click="showDropDown = !showDropDown">
                <EllipsisHorizontal />
            </button>
            <div v-if="showDropDown" class="absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem] shadow-lg">
                <a :href="route('product.show',{id:1})" target="_blank" class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200">
                    <EyeIcon class="h-[1rem]" />
                    <p>View</p> 
                </a>
                <!-- <Link :href="route('admin.sale.edit',{id:1})" class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200">
                    <EditIcon class="h-[0.8rem]" />
                    <p>Edit</p> 
                </Link> -->
                <Link class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200">
                    <EditIcon class="h-[0.8rem]" />
                    <p>Approve</p> 
                </Link>
                <Link class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200">
                    <EditIcon class="h-[0.8rem]" />
                    <p>Reject</p> 
                </Link>
                <Link class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold">
                    <BinIcon class="h-[1rem]" />
                    <p>Delete</p>
                </Link>
            </div>
        </td>
    </tr>
</template>