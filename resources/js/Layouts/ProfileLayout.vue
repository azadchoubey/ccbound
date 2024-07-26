<script setup>
import ArrowLeft from "@/Icons/ArrowLeftIcon.vue";
import ContactsIcon from "@/Icons/ContactsIcon.vue";
import HelpIcon from "@/Icons/HelpIcon.vue";
import LogoutIcon from "@/Icons/LogoutIcon.vue";
import MoneyIcon from "@/Icons/MoneyIcon.vue";
import SubscriptionIcon from "@/Icons/SubscriptionIcon.vue";
import UserGroupIcon from "@/Icons/UserGroupIcon.vue";
import WalletIcon from "@/Icons/WalletIcon.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import BottomTab from "../Components/BottomTab.vue";
import Sidebar from "../Components/Sidebar.vue";
import ToastList from "../Components/ToastList.vue";
import { Inertia } from '@inertiajs/inertia';

defineProps({
  title: String,
});

const showingBottomSheet = ref(false);

const logout = () => {
  Inertia.post(route("logout"));
};

const goBack = () => {
    window.history.back();
}
</script>

<template>
  <div class="flex flex-col max-h-screen min-h-screen">
    
    <ToastList />
    
    <Head :title="title" />

    <div
      :class="`${
        showingBottomSheet ? 'overflow-hidden' : ''
      } bg-gray-100 flex flex-col flex-1`"
    >
      <nav class="block bg-white border-b border-gray-100 md:hidden">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <div class="flex">
              <div class="flex items-center shrink-0">
                <button @click="goBack">
                  <ArrowLeft />
                </button>
              </div>
            </div>
            <div>
              <button
                class="inline-flex items-center justify-center p-2 text-gray-400 transition bg-black rounded-md hover:text-gray-500 hover:bg-gray-400 focus:outline-none focus:bg-gray-500 focus:text-gray-500"
                @click="showingBottomSheet = !showingBottomSheet"
              >
                <svg
                  class="w-6 h-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingBottomSheet,
                      'inline-flex text-white': !showingBottomSheet,
                      
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingBottomSheet,
                      'inline-flex text-white': showingBottomSheet,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <div class="flex m-auto max-w-7xl">

        <Sidebar />
        <!-- Page Content -->
        <main class="max-w-7xl mb-[5rem] w-full md:ml-[20rem]">
          <slot />
        </main>
      </div>

    </div>

    <div v-if="showingBottomSheet" class="fixed w-full h-full transition-all bg-black/30">
      <div class="w-full absolute bottom-0 bg-white px-2 pt-2 pb-[4rem] rounded-lg">
        <div class="mb-2">
          <button
            class="inline-flex items-center justify-center p-2 text-gray-400 transition bg-gray-200 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
            @click="showingBottomSheet = !showingBottomSheet"
          >
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <div class="flex flex-col gap-3">
          <div class="flex gap-2">
            <ContactsIcon class="text-gray-500" />
            <Link :href="route('contacts')">Contacts</Link>
          </div>
          <div class="flex gap-2">
            <WalletIcon class="text-gray-500" />
            <Link :href="route('wallet')">Wallet</Link>
          </div>
          <div class="flex gap-2">
            <SubscriptionIcon class="text-gray-500" />
            <Link :href="route('subscription')">Subscription</Link>
          </div>
          <div class="flex gap-2">
            <UserGroupIcon class="text-gray-500" />
            <Link :href="route('refer')">Refer and earn</Link>
          </div>
          <div class="flex gap-2">
            <HelpIcon class="text-gray-500" />
            <Link :href="route('help')">Help</Link>
          </div>
          <div class="flex gap-2">
            <MoneyIcon class="text-gray-500" />
            <Link :href="route('buy')">Buy Product upload pack</Link>
          </div>
          <div class="flex gap-2">
            <LogoutIcon class="text-gray-500" />
            <button @click="logout">Logout</button>
          </div>
        </div>
      </div>
    </div>
    
    <BottomTab />
  </div>
</template>
