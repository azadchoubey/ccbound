<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref, watch, computed } from "vue";
import PrimaryButton from "../../../components/PrimaryButton.vue";
import TextInput from "../../../components/TextInput.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import ConfirmModal from "../../ConfirmModal.vue";
import { formatDate, formatTime, currentDate } from "../../../Helpers/helpers";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  chat: Object,
  chatrooms: Object,
});

const tab = ref("all");
const chatroomList = ref(props.chatrooms)

const search = ref(null);
const message = ref(null);

const form = useForm({
  chatrooms: []
});
const selected = ref([]);

const setTab = (tabValue) => {
  tab.value = tabValue;
};

const getChatrooms = (page = 1) => {
  axios.get(route('enquiry.chats.show', { page: page, tab: tab.value, chat: props.chat.id })).then(res => {
    chatroomList.value = res.data
  })
}


watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('enquiry.chats.show', { tab: tab.value, chat: props.chat.id, search: newSearchQuery })).then(res => {
      console.log(res)
      chatroomList.value = res.data
    })
  } else {
    window.location.reload()
  }
})

watch(tab, async (newSearchQuery, oldSearchQuery) => {
  axios.get(route('enquiry.chats.show', { tab: tab.value, chat: props.chat.id })).then(res => {
    chatroomList.value = res.data
  })
})

const addStar = (id) => {
  axios.post(route('enquiry.chats.star', { chat: props.chat, chatroom: id }))
    .then(res => {
      console.log(res.data)
    })
}

const shareMessage = () => {
  axios.post(route('chatroom.shareMessage', { message: message.value, chatrooms: selected.value }))
    .then(res => {
      window.location.reload()
    })
}

// const selectAll = computed({
//   get() {
//     return chatroomList.value ? selected.value.length == chatroomList.value.length : false;
//   },
//   set(value) {
//     var temp = []
//     if (value) {
//       chatroomList.value.data.forEach(function (chatroom) {
//         temp.push(chatroom)
//       })
//       selected.value = temp
//     } else {
//       selected.value = temp
//     }
//   }
// })

const selectAll = ref(false);

const selectAllValues = (e) => {
  var temp = []
    if (e.target.checked) {
      selected.value = chatroomList.value.data
      // chatroomList.value.data.forEach(function (chatroom) {
      //   temp.push(chatroom.id)
      // })
      // selected.value = temp
      selectAll.value = true
    } else {
      selected.value = temp
      selectAll.value = false
    }
  }

  
const showModal = ref(false);
const confirmDelete = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const deleteChats = () => {
  showModal.value = false;
  form.chatrooms = selected.value

  form.post(route('chatroom.deleteChats'));
  
  chatroomList.value = null;
  getChatrooms();
  
  selectAll.value = false
  selected.value = []

}

const chatProductName = (title) => {
  return title.replace(props.chat.product_name + '-' + props.chat.cas_no + ' - ', '').trim();
}

const selectedChatRoom = (e) => {
  if(e.target.checked) {
    if(selected.value.length == chatroomList.value.data.length){
      selectAll.value = true;
    }
    
  } else {
      selectAll.value = false;
  }
}

</script>


<style scoped>
.star {
  visibility: hidden;
  font-size: 30px;
  cursor: pointer;
}

.star:before {
  content: "\2606";
  position: absolute;
  top: -10px;
  display: block;
  color: black;
  visibility: visible;
}

.star:checked:before {
  content: "\2605";
  top: -10px;
  color: rgb(255, 255, 0);
  position: absolute;
}
</style>

<template>
  <AppLayout title="Chats">
    <div class="max-w-[45rem]">
      <div class="flex flex-col px-2 bg-white">
        <div class="bg-white p-[1rem]">
          <p class="text-xl font-bold">My Enquiry</p>
          <p class="text-xl font-bold">{{ props.chat.product_name }}</p>
          <p>{{ props.chat.cas_no }}</p>
          <p>Posted By: <b>{{ props.chat.user.name }}</b>@{{ props.chat.user.company.name }}</p>
        </div>
      </div>
      <div class="px-2 mt-2 md:px-0">
        <TextInput type="text" class="w-full p-2 bg-gray-200" v-model="search" placeholder="Search" />

        <div class="mt-4">
          <div class="my-5" v-if="search && chatroomList.data.length > 0 && selected.length > 0">
            <p class="text-xl font-bold">Share message</p>
            <form @submit.prevent="shareMessage">
              <textarea class="w-full rounded-lg focus:outline-none" v-model="message" required></textarea>
              <div class="flex justify-end w-full">
                <PrimaryButton class="bg-blue-600 border-blue-600">Share</PrimaryButton>
              </div>
            </form>
          </div>

          <div class="flex justify-between items-center pr-[2rem]">
            <input type="checkbox" v-model="selectAll"  v-if="chatroomList.data.length > 0" @change="selectAllValues">
            <!-- <button class="px-4 py-2 text-sm text-white bg-black rounded-lg">Block</button> -->
            <button @click="confirmDelete" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg"
              v-if="selected.length > 0">Delete</button>
          </div>
          <div class="grid grid-cols-2 border-b-[1px] border-gray-200">
            <button @click="setTab('all')" :class="`${tab === 'all' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
              <p :class="` ${tab === 'all' ? 'font-bold' : ''
            } w-full flex justify-center`">
                All Chats
              </p>
            </button>
            <button @click="setTab('starred')" :class="`${tab === 'starred' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
              <p :class="` ${tab === 'starred' ? 'font-bold' : ''} w-full flex justify-center`">
                Starred
              </p>
            </button>
          </div>
          <div v-for="chatroom in chatroomList.data" class="mt-4"
            :class="`bg-white flex items-center gap-2 px-[0.2rem]`">
            <div class="flex items-center w-full gap-4 p-1 rounded-lg">
              <input type="checkbox" class="block" :value="chatroom" v-model="selected" @change="selectedChatRoom">
              <div class="relative">
                <input class="block star" type="checkbox" v-model="chatroom.starred" @change="addStar(chatroom.id)">
              </div>
              <Link :href="route('enquiry.chatroom.show', { chatroom: chatroom })"
                class="flex justify-between w-full py-2">
              <div>
                <p v-if="chatroom.last_message && chatroom.last_message.user" class="font-bold">
                  <span
                    v-if="chatroom.members.length > 0 && chatroom.members[1] && chatroom.members[1].id != chatroom.auth_id">
                    {{ chatroom.members[1].name }}</span>
                  <span v-else-if="chatroom.members.length > 0 && chatroom.members[0].id != chatroom.auth_id">
                    {{ chatroom.members[0].name }}</span>
                  <!-- {{ chatroom.last_message.user.name }} -->
                  ({{ chatProductName(chatroom.name) }})
                </p>

                <p :class="`text-sm ${chatroom.message_read !== true ? 'font-bold' : ''}`">
                  <span v-if="chatroom.last_message && chatroom.last_message.user" class="text-blue-400">
                    {{ chatroom.last_message.user.name }}
                  </span>: {{ chatroom?.last_message?.message }}
                </p>
              </div>
              <div v-if="!chatroom.message_read && chatroom.auth_id != chatroom.last_message.user_id" class="w-3 h-3 bg-blue-500 rounded-full"></div>

              </Link>

            </div>
            <span v-if="chatroom.last_message && formatDate(chatroom.last_message.created_at) != currentDate()"
              class="float-right text-sm text-gray-500">
              {{ formatDate(chatroom.last_message.created_at) }}
            </span>
            <span v-if="chatroom.last_message" class="float-right text-sm text-gray-500">
              {{ formatTime(chatroom.last_message.created_at) }}
            </span>
          </div>

          <div class="flex justify-center mt-2">
            <TailwindPagination :data="chatroomList" @pagination-change-page="getChatrooms" />
          </div>
        </div>
      </div>
    </div>
    <ConfirmModal :show="showModal" :message="'This will delete the Message From Both sides.'" @close="closeModal"
      @confirm="deleteChats" />

  </AppLayout>
</template>
