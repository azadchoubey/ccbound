<script setup>
import SearchInput from "@/components/SearchInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
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

const form = useForm({
  selectedChat: ref([])
});

const selectAll = ref(false)

onMounted(() => {
  // sortChats();

  console.log(props.chats);
});


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
  console.log(newSearchQuery)
  if (newSearchQuery.value !== '') {
    axios.get(route('sale.chats.index', { search: newSearchQuery })).then(res => {
      chatsList.value = res.data

    })
  } else {
    window.location.reload()
  }
})

const deleteChat = () => {

  // chatsList.value.data.splice(index, 1);
  form.post(route('sale.chats.delete'))

  getChats();
}

const selectAllChat = (e) => {
  if (e.target.checked) {

    form.selectedChat.value = [];

    chatsList.value.data.forEach((e) => {
      form.selectedChat.push(e.id);
    });

  } else {
    form.selectedChat = [];
  }
  
}

const checkSelectAll = (e) => {

  if (e.target.checked) {
    if (chatsList.value.data.length > 0 && form.selectedChat.length == chatsList.value.data.length) {
      selectAll.value = true
    }

  } else {

    if (chatsList.value.data.length > 0 && form.selectedChat.length != chatsList.value.data.length) {
      selectAll.value = false
    }
  }
  
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
          <Link :href="route('enquiry.chats.index')">
          <p :class="`w-full flex justify-center`">My Enquiries</p>
          </Link>
          <Link :href="route('sale.chats.index')"
            class="border-b-[1px] pb-2 border-black transition-all duration-500 cursor-pointer">
          <p class="flex justify-center w-full font-bold">My Sales</p>
          </Link>
        </div>
        <div class="mt-2">
          <TextInput type="text" class="w-full p-2 bg-gray-200" v-model="search" placeholder="Search" />
        </div>

        <div class="mt-3">
          <SecondaryButton type="button" class="float-right text-white bg-red-600" @click="deleteChat"
            v-if="form.selectedChat.length > 0 || selectAll">
            Delete
          </SecondaryButton>
          <input type="checkbox" v-model="selectAll" class="ml-4" @change="selectAllChat" />
        </div>

        <div class="flex flex-col max-w-full gap-2 mt-3">
          <div v-for="(chat, index) in chatsList.data" class="bg-white p-[1rem] flex justify-between items-center">
            <input type="checkbox" v-model="form.selectedChat" :value="chat.id" @change="checkSelectAll"
              class="float-left" />
            <Link :href="route('sale.chats.show', { chat: chat })" class="w-full ml-3">
            <div>
              <p class="text-xl font-bold">{{ chat.product_name }}</p>
              <p>{{ chat.cas_no }}</p>
            </div>
            <p class="flex items-center justify-center w-6 h-6 text-sm text-white bg-blue-600 rounded-full"
              v-if="chat.unread_count != 0">
              {{ chat.unread_count }}</p>
            </Link>

          </div>
          <div class="flex justify-center mt-2">
            <TailwindPagination :data="chatsList" @pagination-change-page="getChats" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
