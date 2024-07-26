<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import ChatIcon from '../Icons/ChatIcon.vue';
import FormIcon from '../Icons/FormIcon.vue';
import LinkIcon from '../Icons/LinkIcon.vue';
import MoneyIcon from '../Icons/MoneyIcon.vue';
import SettingsIconSolid from '../Icons/SettingsIconSolid.vue';
import Sales from '../Icons/Sales.vue';
import SalesIcon from '../Icons/SalesIcon.vue';
import NewProductIcon from '../Icons/NewProductIcon.vue';


</script>
<template>
  <div :class="`md:hidden bg-white fixed bottom-0 w-full p-4 flex justify-between border-t-[1px] border-gray-400`"
    id="tabs">
    <Link :href="route('enquiry.index')">
    <FormIcon class="w-6 h-6" />
    </Link>
    <Link :href="route('sales.index')">
      <SalesIcon :classname="'w-11 h-6 '" class="text-blue-400" />
    </Link>
    <Link :href="route('product.index')">
      <NewProductIcon :classname="'w-10 h-6'" />
    </Link>
    <Link :href="route('enquiry.chats.index')">
    <ChatIcon class="text-blue-400 w-7 h-7" />
    </Link>
    <Link :href="route('links')">
    <LinkIcon class="text-blue-400" />
    </Link>
    <!-- <Link :href="route('settings')">
      <SettingsIconSolid />
      </Link> -->
  </div>
</template>