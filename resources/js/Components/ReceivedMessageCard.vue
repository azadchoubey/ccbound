<script setup>
defineProps({
  message: Object,
  name: String,
  company: String,
  profile_image: String,
  time:String
});
</script>
<template>
  <div class="flex w-full mt-2">
    <div class="flex items-end w-3/4">
      <!-- <img :src="profile_image" alt="profile image" class="h-[2.5rem] rounded-full"> -->
      <div class="bg-[#EEEEEE] p-2 rounded-t-xl rounded-br-xl">
        <p class="text-sm font-semibold">{{ name }} @{{ company }}</p>
        <p v-if="message.type === 'text'" class="text-sm">{{message.message}}</p>
        <a v-if="message.type === 'file'" :href="message.link" target="_blank" class="flex justify-between w-full gap-2 px-1 py-2 bg-gray-500/20">
          <!-- <p class="text-sm">testpdf.asdf</p> -->
          <button class="flex items-center justify-center w-5 h-5 border border-black rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>
          </button>
        </a>
        <div class="flex justify-end w-full">
            <p class="text-xs">{{ time.slice(0,16).replace('T',' ') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
