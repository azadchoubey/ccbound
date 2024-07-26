<script setup>
import ChemicalViewLayout from "@/Layouts/ChemicalViewLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import BuildingIcon from "../../Icons/BuildingIcon.vue";
import UserIcon from "../../Icons/UserIcon.vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  enquiry: Object,
});
</script>

<template>
  <ChemicalViewLayout title="Enquiry" :link="route('enquiry.index')">
    <div class="md:bg-white rounded-lg min-w-[50rem]">
      <div class="px-2 border-b border-gray-200">
        <div class="p-2">
          <p class="text-xl font-bold">{{ enquiry.product_name}}</p>
          <p>{{ enquiry.cas_no }}</p>
        </div>
        <div class="w-full h-[15rem] flex justify-center">
          <img :src="enquiry.structure_url" class="object-fill max-w-full max-h-full" alt="" />
        </div>

      </div>
      <div class="flex-1 w-full h-auto p-2 px-5 bg-white rounded-3xl">
        <div class="grid grid-cols-2 py-5">
          <div class="flex flex-col items-center justify-center w-full">
            <p class="font-bold">Quality</p>
            <p>{{ enquiry.quality_required }}</p>
          </div>
          <div class="flex flex-col items-center justify-center w-full">
            <p class="font-bold">Purity</p>
            <p>{{ enquiry.purity_required }}</p>
          </div>
        </div>

        <div>
          <p class="text-xl font-semibold">Description</p>
          <p>{{ enquiry.description }}</p>
        </div>

        <div class="mt-2">
          <p class="text-xl font-semibold">Documents</p>
          <Link v-if="enquiry.docs !== null" :href="enquiry.docs_url">Docs</Link>
        </div>

        <div class="grid grid-cols-2 mt-4">
          <Link :href="route('profile.display',{id:enquiry.user_id})" class="flex">
            <UserIcon />
            <p>{{ enquiry.user.name }}</p>
          </Link>
          <Link :href="route('company.show',{id:enquiry.user.company.id})" class="flex">
            <BuildingIcon class="text-slate-900" />
            <p>{{ enquiry.user.company.name }}</p>
          </Link>
        </div>
      </div>
    </div>
  </ChemicalViewLayout>
</template>
