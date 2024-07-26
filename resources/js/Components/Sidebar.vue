<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import ChatIcon from '../Icons/ChatIcon.vue';
import FormIcon from '../Icons/FormIcon.vue';
import SettingsIcon from '../Icons/SettingsIcon.vue';

// import Sales from '../Icons/Sales.vue';
// import MoneyIcon from '../Icons/MoneyIcon.vue';
import SalesIcon from '../Icons/SalesIcon.vue';
// import LogoutIcon from "../Icons/LogoutIcon.vue";
import NewProductIcon from "../Icons/NewProductIcon.vue";

import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const logout = () => {
  Inertia.post(route("logout"));
};

let active = 0;

const activePage = (page) => {
  active = page;
  // console.log('function ',active);
}
const page = usePage();
const url = computed(() =>  page.props.value.route  )

const getLinkClasses = (...routes) => {

  const isActive = routes.some(route => url.value == route);
  
  return `relative flex flex-row items-center h-[4rem] focus:outline-none ${
    isActive ? 'bg-gray-200 text-gray-600 text-gray-800 border-l-4 border-transparent border-indigo-500 pr-6' : ''
  } hover:bg-gray-200 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6`;
};
// console.log('outside function ' ,active);

</script>
<template>
  <div class="flex-col hidden min-h-screen text-gray-800 md:flex bg-gray-50">
    <div class="fixed flex flex-col left-0 md:w-[15rem] lg:w-[20rem] bg-white h-full border-r">
      <div class="flex flex-col justify-between flex-grow overflow-x-hidden overflow-y-auto">
        <ul class="flex flex-col py-4 space-y-1">
          <li class="px-5">
            <div class="flex flex-row items-center h-8">
              <!-- <div class="text-xl tracking-wide">CCBond</div> -->
            </div>
            <!-- <p class="text-xl font-semibold">{{ $page.props.user.name }}</p> -->
          </li>
          <li>
          
            <Link
              :href="route('enquiry.index')"
              :class="getLinkClasses('enquiry.index')"
            >
              <span class="inline-flex items-center justify-center ml-4">
                <FormIcon class="w-5 h-5 text-blue-400" />
              </span>
              <span class="ml-2 text-sm tracking-wide truncate">Enquiries</span>
            </Link>
          </li>
          <li>
            <Link :href="route('sales.index')" @click="activePage(1)"
            :class="getLinkClasses('sales.index')">
            <span class="inline-flex items-center justify-center ml-4">
              <!-- <Sales :classname="'w-10 h-16'" class="text-blue-400" /> -->
              <SalesIcon :classname="'w-10 h-16 text-blue-400'" />
            </span>
            <span class="text-sm tracking-wide truncate ">Sales</span>
            </Link>
          </li>
          <li>
            <Link :href="route('product.index')"  @click="activePage(2)"
            :class="getLinkClasses('product.index')">            
            <span class="inline-flex items-center justify-center ml-4">
              <!-- <MoneyIcon class="text-blue-400"/> -->
              <NewProductIcon :classname="'w-10 h-16'" />
            </span>
            <span class="text-sm tracking-wide truncate">Products</span>
            </Link>
          </li>
          <li>
            <Link :href="route('enquiry.chats.index')"  @click="activePage(3)"
            :class="getLinkClasses('enquiry.chats.index')">            
            <span class="inline-flex items-center justify-center ml-4">
              <ChatIcon  :classname="'w-6 h-6'" class="text-blue-400"/>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate">Chats</span>
            </Link>
          </li>
          <li>
            <Link :href="route('links')"  @click="activePage(4)"
            :class="getLinkClasses('links')" >           
            <span class="inline-flex items-center justify-center ml-4">
              <SettingsIcon class="text-blue-400"/>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate">Settings</span>
            </Link>
          </li>
          <!-- <li>
            <Link :href="route('settings')"  @click="activePage(5)"
            :class="getLinkClasses('settings')" > 
                        <p class="flex rounded-[0.3rem] justify-center items-center ml-4 p-[0.1rem]">
              <SettingsIconSolid class="text-blue-400"/>
            </p>
            <span class="ml-2 text-sm tracking-wide truncate">Settings</span>
            </Link>
          </li>
          <li>
            <button @click="logout"
              class="relative flex flex-row items-center h-[4rem] focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
              <p class="flex rounded-[0.3rem] justify-center items-center ml-4 p-[0.1rem]">
                <LogoutIcon class="text-blue-400"/>
              </p>
              <span class="ml-2 text-sm tracking-wide truncate">Logout</span>
            </button>
          </li> -->
        </ul>
      </div>
    </div>
  </div>
</template>
