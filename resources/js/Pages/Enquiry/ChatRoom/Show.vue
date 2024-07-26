<script setup>
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";
import ReceivedMessageCard from "@/Components/ReceivedMessageCard.vue";
import SentMessageCard from "@/Components/SentMessageCard.vue";
import ClipIcon from "@/Icons/ClipIcon.vue";
import EllipsisHorizontal from "@/Icons/EllipsisHorizontal.vue";
import PaperAirPlaneIcon from "@/Icons/PaperAirPlaneIcon.vue";
import UploadIcon from "@/Icons/UploadIcon.vue";
import UserIcon from "@/Icons/UserIcon.vue";
import ChatRoomLayout from "@/Layouts/ChatRoomLayout.vue";
import axios from "axios";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  chatroom: Object,
  messages: Object,
  auth_member: Object,
  readBy: Object,
});

const page = usePage();
const showOptions = ref(false);
const message = ref(null);

const form = useForm({
  file: []
})
const chatroomMessages = ref(props.messages)
// setInterval(function(){ 
//     getMessages()
// }, 1000);

onMounted(() => {
  scroll(0)
})

const handleMessageDeleted = (deletedMessageId) => {
  chatroomMessages.value = chatroomMessages.value.filter(message => message.id !== deletedMessageId);
}


const scroll = (height) => {
  var objDiv = document.getElementById("container");
  objDiv.scrollTop = objDiv.scrollHeight + height;
}
const getMessages = async () => {
  await axios.get(route('enquiry.chatroom.show', { chatroom: props.chatroom }))
    .then(res => {
      chatroomMessages.value = res.data;
    })
  scroll(20)
}
const sendMessage = () => {
  if (message.value !== null && message.value !== '') {
    axios.post(route('chatroom.newMessage', { id: props.chatroom.id }), {
      message: message.value
    })
      .then(res => {
        console.log(res)
        if (res.status === 201) {
          message.value = ''
          getMessages()
        }
      })
      .catch(error => {
        console.log(error)
      })
  }
}

const uploadFile = () => {
  showOptions.value = false
  form.post(route('chatroom.fileUpload', { id: props.chatroom.id }))
  form.file = [];
}

const shareDetails = () => {
  message.value = 'Email: ' + page.props.value.user.email + ' Number: ' + page.props.value.user.number;
  sendMessage();
  showOptions.value = false
}
</script>

<template>
  <ChatRoomLayout title="Chatroom" :showInfo=true
    :infoLink="route('enquiry.chatroom.settings', { 'chatroom': $props.chatroom })"
    :name="`My Enquiry - ${props.chatroom.name}`">
    <div class="max-w-[40rem] m-auto pb-5">

      <!-- chat room  -->
      <div id="container" class="px-2 flex-1 mb-[5rem] w-full bg-white h-[calc(100vh_-_150px)] overflow-y-auto">
        <div class="w-full p-1">
          <div class="" v-for="message in chatroomMessages">
            <SentMessageCard v-if="message.user.id === $page.props.user.id" :message="message"
              :name="message.user.name" :company="message.user.company.name"
              :profile_image="message.user.profile_photo_url" :time="message.created_at" @messageDeleted="handleMessageDeleted" />

            <ReceivedMessageCard v-else :message="message" :name="message.user.name"
              :company="message.user.company.name" :profile_image="message.user.profile_photo_url"
              :time="message.created_at" />
          </div>
          <!-- <div class="flex justify-end w-full">
            <p class="text-sm">
              seen by
              <span v-for="user in readBy">{{ user.name }}, </span>
            </p>
          </div> -->
        </div>
      </div>
      <div class="w-full fixed bottom-0 max-w-[40rem]">
        <!-- actions  -->
        <div v-if="showOptions" class="flex flex-col p-1 mx-2 mb-2 bg-white border border-gray-200 rounded-lg">
          <div class="flex justify-end">
            <button
              class="inline-flex items-center justify-center p-1 text-gray-400 transition bg-gray-200 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
              @click="showOptions = !showOptions">
              <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="flex justify-between px-[5rem]">
            <div class="flex flex-col items-center">
              <button @click="shareDetails" class="inline-block p-2 bg-blue-600 rounded-full">
                <UserIcon class="text-white" />
              </button>
              <p class="text-sm">Share My Details</p>
            </div>
            <div class="flex flex-col items-center">
              <button class="inline-block p-2 bg-green-600 rounded-full"
                onclick="document.getElementById('file').click()">
                <UploadIcon class="text-white" />
              </button>
              <p>Upload</p>
            </div>
            <div class="flex flex-col items-center">
              <Link :href="route('enquiry.chatroom.settings', { chatroom: chatroom })"
                class="block p-2 bg-white border border-gray-200 rounded-full">
              <EllipsisHorizontal class="text-red-600" />
              </Link>
              <p>More</p>
            </div>
          </div>
        </div>
        <div class="p-2 px-3 bg-white">
          <div v-if="auth_member.pivot.chat_left == 0" class="flex">
            <div class="flex items-center flex-1 px-3 py-1 bg-gray-200 rounded-3xl">
              <button @click="showOptions = !showOptions">
                <ClipIcon />
              </button>
              <input type="file" class="hidden" id="file" multiple @input="form.file = $event.target.files"
                v-on:change="uploadFile()">
              <input type="text" v-model="message" @keyup.enter="sendMessage()" placeholder="Type a message"
                class="w-full bg-gray-200 border-0 focus:outline-none focus:ring-0">
            </div>
            <div class="flex items-center">
              <button @click="sendMessage()" class="px-3 py-2 text-white bg-blue-700 rounded-2xl">
                <PaperAirPlaneIcon />
              </button>
            </div>
          </div>
          <div v-else>
            <p class="flex justify-center">You are no longer member of the group</p>
          </div>
        </div>
      </div>

    </div>
  </ChatRoomLayout></template>
