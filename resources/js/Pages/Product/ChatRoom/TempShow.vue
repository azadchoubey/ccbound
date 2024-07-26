<script setup>
import ClipIcon from "@/Icons/ClipIcon.vue";
import EllipsisHorizontal from "@/Icons/EllipsisHorizontal.vue";
import PaperAirPlaneIcon from "@/Icons/PaperAirPlaneIcon.vue";
import UploadIcon from "@/Icons/UploadIcon.vue";
import UserIcon from "@/Icons/UserIcon.vue";
import ChatRoomLayout from "@/Layouts/ChatRoomLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  product: Object
});

const showOptions = ref(false);
const message = ref(null);

const sendMessage = () => {
  if (message.value !== null && message.value !== '') {
    Inertia.post(route('product.chatroom.createnew', { 'message': message.value, 'product': props.product }))
  }
}
const uploadFile = () => {
  showOptions.value = false
}
</script>

<template>
  <ChatRoomLayout title="Chatroom" :showInfo=false :navigationBack="'/chats/enquiry/asdf'"
    :name="`My Enquiry - ${props.product.product_name} - ${props.product.cas_no} - Initiated By ${$page.props.user.name} - Posted By ${props.product.user.name}`"
    :profile_image="`/assests/images/avatar.jpg`">
    <div class="max-w-[40rem] m-auto pb-5">
      <!-- chat room  -->
      <div class="px-2 flex-1 mb-[5rem] w-full bg-white h-[calc(100vh_-_150px)] overflow-y-auto">
        <div class="w-full p-1">

        </div>
      </div>
      <div class="w-full fixed bottom-0 max-w-[40rem]">
        <!-- actions  -->
        <div v-if="showOptions" class="flex flex-col mb-2 p-1 mx-2 border border-gray-200 rounded-lg bg-white">
          <div class="flex justify-end">
            <button
              class="bg-gray-200 inline-flex items-center justify-center p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
              @click="showOptions = !showOptions">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="flex justify-between px-[5rem]">
            <div class="flex flex-col items-center">
              <button @click="show" class="bg-blue-600 inline-block p-2 rounded-full">
                <UserIcon class="text-white" />
              </button>
              <p class="text-sm">Share My Deatils</p>
            </div>
            <div class="flex flex-col items-center">
              <button class="bg-green-600 inline-block p-2 rounded-full"
                onclick="document.getElementById('file').click()">
                <UploadIcon class="text-white" />
              </button>
              <p>Upload</p>
            </div>
            <div class="flex flex-col items-center">
              <Link class="bg-white block border border-gray-200 p-2 rounded-full">
              <EllipsisHorizontal class="text-red-600" />
              </Link>
              <p>More</p>
            </div>
          </div>
        </div>
        <div class="p-2 px-3 bg-white" id="message-tab">
          <div class="flex">
            <div class="bg-gray-200 flex items-center flex-1 rounded-3xl px-3 py-1">
              <button @click="showOptions = !showOptions">
                <ClipIcon />
              </button>
              <input type="file" class="hidden" id="file" v-on:change="uploadFile()">
              <input type="text" v-model="message" @keyup.enter="sendMessage()" placeholder="Type a message"
                class="w-full border-0 bg-gray-200 focus:outline-none focus:ring-0">
            </div>
            <div class="flex items-center">
              <button @click="sendMessage()" class="text-white bg-blue-700 px-3 py-2 rounded-2xl">
                <PaperAirPlaneIcon />
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </ChatRoomLayout>
</template>
