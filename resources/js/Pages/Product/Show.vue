<script setup>
import ChemicalViewLayout from "@/Layouts/ChemicalViewLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import BuildingIcon from "../../Icons/BuildingIcon.vue";
import ChatIcon from "../../Icons/ChatIcon.vue";
import UserIcon from "../../Icons/UserIcon.vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <ChemicalViewLayout title="Enquiry" :link="route('sales.index')">
    <div class="rounded-lg md:bg-white">
      <div class="px-2 border-b border-gray-200">
        <div class="p-2">
          <p class="text-xl font-bold">Benzene</p>
          <p>1111-1111-1111</p>
        </div>
        <div class="w-full h-[15rem] flex justify-center">
          <img src="/assests/images/benzene.png" class="object-fill max-w-full max-h-full" alt="" />
        </div>

      </div>
      <div class="flex-1 w-full h-auto p-2 px-5 bg-white rounded-3xl">
        <!-- <div class="grid grid-cols-2 py-5">
          <div class="flex flex-col items-center justify-center w-full">
            <p>Quality Required</p>
            <p>34</p>
          </div>
          <div class="flex flex-col items-center justify-center w-full">
            <p>Purity Required</p>
            <p>45</p>
          </div>
        </div> -->

        <div>
          <p class="text-xl font-semibold">Description</p>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusamus, rerum odio sunt alias nihil optio? Nemo,
            tempore maxime voluptatibus velit ipsam ipsum dignissimos animi ducimus rem vitae error aperiam soluta.</p>
        </div>

        <div class="mt-2">
          <p class="text-xl font-semibold">Documents</p>
          <p>Docs</p>
        </div>

        <div class="grid grid-cols-2 mt-4">
          <div class="flex">
            <UserIcon />
            <p>Rakesh</p>
          </div>
          <div class="flex">
            <BuildingIcon class="text-slate-900" />
            <p>Resolute B2B</p>
          </div>
        </div>
        <div class="w-full px-4 my-5">
          <Link class="flex items-center justify-center w-full gap-2 p-2 text-xl text-white rounded-lg bg-slate-900 ">
          Chat
          <ChatIcon />
          </Link>
        </div>
      </div>
    </div>
  </ChemicalViewLayout>
</template>
