<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchInput from "@/components/SearchInput.vue";
import ChemicalDetailsCard from "../../components/ChemicalDetailsCard.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});

const tab = ref("enquiry");

const setTab = (tabValue) => {
  tab.value = tabValue;
};
</script>

<template>
  <AppLayout title="Chats">
    <div class="flex justify-between p-2">
      <p class="px-2 text-xl font-semibold">Chats</p>
    </div>
    <div class="px-2 max-w-[40rem]">

      <div class="mt-2">
        <div class="grid grid-cols-2 border-b-[1px] border-gray-200">
          <div
            @click="setTab('enquiry')"
            :class="`${
              tab === 'enquiry' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500 cursor-pointer`"
          >
            <p :class="` ${tab === 'enquiry' ? 'font-bold':''} w-full flex justify-center`">My Enquiries</p>
          </div>
          <div
            @click="setTab('sales')"
            :class="`${
              tab === 'sales' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500 cursor-pointer`"
          >
            <p :class="` ${tab === 'sales' ? 'font-bold':''} w-full flex justify-center`">My Sales</p>
          </div>
        </div>
        <div class="mt-2">
          <SearchInput class="w-full p-2 bg-gray-200" placeholder="Search" />
        </div>

        <div class="mt-2 max-w-[40rem] flex flex-col gap-2">
          
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Benzene</p>
              <p>111-111-111</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">13</p>
          </Link>
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Tetrachloromethane</p>
              <p>093-192-999</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">13</p>
          </Link>
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Silicon carbide</p>
              <p>935-963-789</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">21</p>
          </Link>
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Sodium hydroxide</p>
              <p>562-653-568</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">0</p>
          </Link>
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Sulfuric acid</p>
              <p> 658-632-578</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">19</p>
          </Link>
          <Link :href="route('chats.users',{type:tab,casno:'asdf'})" class="bg-white p-[1rem] flex justify-between items-center">
            <div>
              <p class="text-xl font-bold">Boric acid</p>
              <p>854-653-789</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full">1</p>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
