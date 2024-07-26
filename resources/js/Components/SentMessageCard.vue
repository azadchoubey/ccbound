<script setup>
import axios from 'axios';
import { ref } from "vue";

const props = defineProps({
  message: Object,
  name: String,
  company: String,
  profile_image: String,
  time: String
});

const emit = defineEmits(['messageDeleted']);

const deleteMessage = () => {
  axios.post(route('chatroom.deleteMessage', { message: props.message.id }))
    .then(() => {
      emit('messageDeleted', props.message.id);
    })
    .catch(error => {
      console.error('Error deleting message:', error);
    });
}

</script>
<template>
  <div class="flex justify-end w-full mt-2">
    <div class="flex items-end">
      <div class="p-2 text-white bg-[#7CC7F9] rounded-t-xl rounded-bl-xl" >
        
        <div class="flex justify-between">

          <p class="text-sm font-semibold">{{ name }} @{{ company }}</p>
        </div>
        <p v-if="message.type === 'text'" class="text-sm">{{ message.message }}</p>
        <a v-if="message.type === 'file'" :href="message.link" target="_blank"
          class="flex justify-between w-full gap-2 px-1 py-2 bg-gray-500/20">
          <p class="text-sm">{{ message.message }}</p>
          <button class="flex items-center justify-center w-5 h-5 border border-black rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>
          </button>
        </a>
        <div class="flex justify-end w-full">
          <p class="text-xs">{{ time.slice(0, 16).replace('T', ' ') }}</p>
        </div>
      </div>
      <!-- <div class="">
        <button @click="deleteMessage" class="ml-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5 p-1 text-white bg-red-500 rounded-lg">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
          </svg>
        </button>
        <img :src="profile_image" alt="profile image" class="h-[2.5rem] rounded-full">
      </div> -->

    </div>
  </div>
</template>
