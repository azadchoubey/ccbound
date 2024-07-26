<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { computed, onMounted, onUnmounted, ref } from "vue";
import EllipsisHorizontal from "@/Icons/EllipsisHorizontal.vue";
import EyeIcon from "@/Icons/EyeIcon.vue";
import EditIcon from "@/Icons/EditIcon.vue";
import BinIcon from "@/Icons/BinIcon.vue";

const showDropDown = ref(false);

const closeOnEscape = (e) => {
    if (showDropDown.value && e.key === "Escape") {
        showDropDown.value = false;
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));
</script>
<template>
    <div v-show="showDropDown" class="fixed inset-0 z-40" @click="showDropDown = false" />
    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">1/12/2023</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold" :href="`/organizations/asdf/edit`">
                BDG452
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">Rakesh</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">1000</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">100</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">9000</p>
        </td>
        <td class="border-t relative flex flex-col justify-center items-center pt-2.5">
            <button @click="showDropDown = !showDropDown">
                <EllipsisHorizontal />
            </button>
            <div v-if="showDropDown" class="absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem]">
                <Link :href="route('admin.product.create', { user: 1 })"
                    class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold">
                <p>Upload</p>
                </Link>
            </div>
        </td>
    </tr>
</template>
