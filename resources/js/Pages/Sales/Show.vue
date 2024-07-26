<script setup>
import ChemicalViewLayout from "@/Layouts/ChemicalViewLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import ChatIcon from "../../Icons/ChatIcon.vue";
import UserIcon from "../../Icons/UserIcon.vue";
import BuildingIcon from "../../Icons/BuildingIcon.vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  sale: Object,
});
</script>

<template>
  <ChemicalViewLayout title="Sales" :link="route('sales.index')">
    <div class="md:bg-white rounded-lg pb-5 min-w-[50rem]">
      <div class="px-2 border-b border-gray-200">
        <div class="p-2">
            <p class="text-lg font-semibold">{{ sale.product_name }}</p>
            <p>{{ sale.cas_no }}</p>
        </div>

        <div class="w-full h-[15rem] flex justify-center">
          <img :src="sale.structure_url" class="object-fill max-w-full max-h-full" alt=""/>
        </div>

      </div>
      <div class="flex-1 w-full h-auto px-5 bg-white rounded-3xl">
        <div class="grid grid-cols-2 py-5">
          <div class="flex flex-col items-center justify-center w-full">
            <p class="font-bold">Quality</p>
            <p>{{ sale.quality_required }}</p>
          </div>
          <div class="flex flex-col items-center justify-center w-full">
            <p class="font-bold">Purity</p>
            <p>{{ sale.purity_required }}</p>
          </div>
        </div>

        <div>
          <p class="text-xl font-semibold">Description</p>
          <p>{{ sale.description }}</p>
        </div>

        <div class="mt-2">
          <p class="text-xl font-semibold">Documents</p>
          <Link v-if="sale.docs !== null" :href="sale.docs_url">Docs</Link>
        </div>

        <div class="grid grid-cols-2 mt-4">
          <Link :href="route('profile.display',{id:sale.user_id})" class="flex">
            <UserIcon />
            <p>{{ sale.user.name}}</p>
          </Link>
          <Link :href="route('company.show',{id:sale.user.company.id})" class="flex">
            <BuildingIcon class="text-slate-900" />
            <p>{{ sale.user.company.name }}</p>
          </Link>
        </div>
        <!-- <div class="w-full px-4 my-5">
          <Link v-if="$page." class="flex items-center justify-center w-full gap-2 p-2 text-xl text-white rounded-lg bg-slate-900 ">
            Chat
            <ChatIcon />
          </Link>
        </div> -->
      </div>
    </div>
  </ChemicalViewLayout>
</template>
