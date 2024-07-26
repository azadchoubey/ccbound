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
      <p
        class="flex items-center px-6 py-4 font-semibold"
        :href="`/organizations/asdf/edit`"
      >
        #AWE564
      </p>
    </td>
    <td class="border-t">
      <p class="flex items-center px-6 py-4 font-semibold">₹ 600</p>
    </td>
    <td class="border-t">
      <p class="flex items-center px-6 py-4 font-semibold">6 Months</p>
    </td>
    <td class="border-t">
      <p class="flex items-center px-6 py-4 font-semibold">180 Days</p>
    </td>
    <td class="border-t relative flex flex-col justify-center items-center pt-2.5">
      <button @click="showDropDown = !showDropDown">
        <EllipsisHorizontal />
      </button>
      <div
        v-if="showDropDown"
        class="absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem]"
      >
        <Link
          :href="route('admin.subscription.edit', { id: 1 })"
          class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200"
        >
          <EditIcon class="h-[0.8rem]" />
          <p>Edit</p>
        </Link>
        <Link class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold">
          <BinIcon class="h-[1rem]" />
          <p>Delete</p>
        </Link>
      </div>
    </td>
  </tr>
</template>
