<script setup>
import SearchInput from "@/components/SearchInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch, onMounted } from "vue";
import TextInput from "../../../components/TextInput.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import SecondaryButton from '../../../Components/SecondaryButton.vue';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  chats: Object,
});

const chatsList = ref(props.chats)
const search = ref(null)

console.log(chatsList);

const getChats = (page = 1) => {
  axios.get(route('sale.chats.index', { page: page }))
    .then(res => {
      chatsList.value = res.data
    })
}

const sortChats = () => {
  chatsList.value.sort((a, b) => {
    return new Date(b.last_message) - new Date(a.last_message);
  });
};

watch(search, async (newSearchQuery, oldSearchQuery) => {
  
  if (newSearchQuery.value !== '') {
    axios.get(route('enquiry.chats.index', { search: newSearchQuery })).then(res => {
      chatsList.value = res.data
      
    })
  } else {
    window.location.reload()
  }
})

const deleteChat = (enquiry_chat, index) => {
  
  chatsList.value.data.splice(index,1);
  axios.delete(route('enquiry.chats.delete',{id: enquiry_chat.id}))
}

</script>

<template>
  <AppLayout title="Chats">
    <div class="flex justify-between p-2">
      <p class="px-2 text-xl font-semibold">Chats</p>
    </div>
    <div class="px-2 max-w-[40rem]">

      <div class="mt-2">
        <div class="grid grid-cols-2 border-b-[1px] border-gray-200">
          <Link :href="route('enquiry.chats.index')"
            class="border-b-[1px] pb-2 border-black transition-all duration-500 cursor-pointer">
          <p :class="` font-bold w-full flex justify-center`">My Enquiries</p>
          </Link>
          <Link :href="route('sale.chats.index')">
          <p class="flex justify-center w-full">My Sales</p>
          </Link>
        </div>
        <div class="mt-2">
          <TextInput type="text" class="w-full p-2 bg-gray-200" v-model="search" placeholder="Search" />
        </div>

        <div class="mt-2 max-w-[40rem] flex flex-col gap-2">
          <div v-for="(chat, index) in chatsList.data" class="bg-white p-[1rem] flex justify-between items-center">
            <Link :href="route('enquiry.chats.show', { chat: chat })">
            <div>
              <p class="text-xl font-bold">{{ chat.product_name }}</p>
              <p>{{ chat.cas_no }}</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full"
              v-if="chat.unread_count != 0">
              {{ chat.unread_count }}</p>
            
            </Link>
            <SecondaryButton type="button" class="text-white bg-red-600" @click="deleteChat(chat, index)">Delete</SecondaryButton>
          </div>
          <div class="flex justify-center mt-2">
            <TailwindPagination :data="chatsList" @pagination-change-page="getChats" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
