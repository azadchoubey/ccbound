<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import axios from "axios";
import { ref, watch, onMounted } from 'vue';
import UserGroupIcon from "../../../Icons/UserGroupIcon.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from "../../../Helpers/helpers";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  usersCount: Number,
  adminsCount: Number,
  trail: String,
  subscribed: Number,
  notSubscribed: Number,
  expired: Number,
  users: Object,
});


const usersList = ref(props.users)

console.log(usersList);
const search = ref();

// onMounted(() => {
//   const dateObj = new Date();
//    const currentDate = dateObj.getFullYear()+"-"+dateObj.getDate()+"-"+dateObj.getDate();
//    console.log(currentDate);
// })

const getUsers = (page = 1) => {
  axios.get(route('admin.user.index', { page: page }))
    .then(res => {
      usersList.value = res.data
    })
}

const updateStatus = (user, status) => {
  axios.patch(route('admin.user.update', { user: user, status: status, type: "update_status" }))
    .then(res => {
      window.location.reload();
    })
}

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.user.index', { search: newSearchQuery })).then(res => {
      usersList.value = res.data
    })
  } else {
    window.location.reload()
  }
})
</script>

<template>
  <AdminLayout title="Users">
    <div class="flex flex-wrap gap-5 p-4">
      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-violet-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-violet-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ adminsCount }}</p>
          <p class="text-sm font-bold text-gray-400">Admins</p>
        </div>
      </div>

      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-blue-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-blue-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ usersCount }}</p>
          <p class="text-sm font-bold text-gray-400">Users</p>
        </div>
      </div>

      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-green-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-green-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ trail }}</p>
          <p class="text-sm font-bold text-gray-400">Trail</p>
        </div>
      </div>

      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-green-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-green-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ subscribed }}</p>
          <p class="text-sm font-bold text-gray-400">Subscribed</p>
        </div>
      </div>

      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-red-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-red-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ notSubscribed }}</p>
          <p class="text-sm font-bold text-gray-400">Non Subscribed</p>
        </div>
      </div>

      <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[15rem]">
        <div class="bg-red-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
          <UserGroupIcon class="text-red-600" />
        </div>
        <div>
          <p class="text-3xl font-black">{{ expired }}</p>
          <p class="text-sm font-bold text-gray-400">Expired</p>
        </div>
      </div>
    </div>
    <div class="px-[1rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" v-model="search" />
      </div>
      <div class="bg-white rounded-md shadow overfl">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Name</th>
              <th class="px-6 pt-6 pb-4">Email</th>
              <th class="px-6 pt-6 pb-4">Number</th>
              <th class="px-6 pt-6 pb-4">Subscription Status</th>
              <th class="px-6 pt-6 pb-4">End Date</th>
              <th class="flex justify-center px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in usersList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <!-- {{ user }} -->
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(user.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ user.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ user.email }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ user.number }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p>{{ user.company.status }}</p>
                <!-- <p v-if="user.company.subscription.subscription === '#SUB000000'"
                  class="px-2 text-sm text-green-600 bg-green-200 rounded-xl">Free trail</p>
                <p v-else class="px-2 text-sm text-green-600 bg-green-200 rounded-xl">Subscribed</p> -->
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ user.company.subscription?formatDate(user.company.subscription.end_date):'' }}</p>
              </td>
              <td class="space-x-2 border-t">
                <a :href="route('profile.display', { id: user.id })" target="_blank"
                  class="text-blue-700 hover:underline">View</a>
                <button v-if="user.active === 0" @click="updateStatus(user, 1)" class="text-green-600">Activate</button>
                <button v-if="user.active === 1" @click="updateStatus(user, 0)" class="text-red-600">Deactivate</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="usersList" @pagination-change-page="getUsers" />
      </div>
    </div>
  </AdminLayout>
</template>
