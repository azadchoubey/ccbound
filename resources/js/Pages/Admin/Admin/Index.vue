<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import UserGroupIcon from "../../../Icons/UserGroupIcon.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from '../../../Helpers/helpers';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  superadmin: Number,
  salesadmin: Number,
  dataadmin: Number,
  accountsadmin: Number,
  admins: Object,
});

const adminsList = ref(props.admins.data)

const adminRole = (role) => {
  if (role === 'super_admin') {
    return "Super Admin";
  } else if (role === 'data_admin') {
    return "Data Admin";
  } else if (role === 'sales_admin') {
    return "Sales Admin";
  } else if (role === 'accounts_admin') {
    return "Accounts Admin";
  } else {
    return;
  }
}

const adminStatus = (status) => {
  if (status === 1) {
    return "Active";
  } else {
    return "Deactive"; l
  }
}

const update = (admin, status) => {
  axios.post(route('admin.admin.updateStatus', { admin: admin, status: status }))
    .then(res => {
      if (res.status === 200) {
        console.log(res.data)
        // salesList.value = {...res.data,...salesList.value}
        window.location.reload()
      }
    })
}

const search = ref();

const getAdmins = (page = 1) => {
  axios.get(route('admin.admin.index', { page: page }))
    .then(res => {
      adminsList.value = res.data
    })
}

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.admin.index', { search: newSearchQuery })).then(res => {
      adminsList.value = res.data.data
    })
  } else {
    window.location.reload()
  }
})
</script>

<template>
  <AdminLayout title="Admins">
    <div class="px-[2rem]">
      <div class="flex flex-wrap gap-5 py-4">
        <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[16rem]">
          <div class="bg-violet-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
            <UserGroupIcon class="text-violet-600" />
          </div>
          <div>
            <p class="text-3xl font-black">{{ superadmin }}</p>
            <p class="text-sm font-bold text-gray-400">Super Admins</p>
          </div>
        </div>

        <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[16rem]">
          <div class="bg-cyan-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
            <UserGroupIcon class="text-cyan-600" />
          </div>
          <div>
            <p class="text-3xl font-black">{{ accountsadmin }}</p>
            <p class="text-sm font-bold text-gray-400">Account Admins</p>
          </div>
        </div>

        <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[16rem]">
          <div class="bg-blue-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
            <UserGroupIcon class="text-blue-600" />
          </div>
          <div>
            <p class="text-3xl font-black">{{ salesadmin }}</p>
            <p class="text-sm font-bold text-gray-400">Sales Admins</p>
          </div>
        </div>

        <div class="bg-white flex gap-2 rounded-lg p-[2rem] w-[16rem]">
          <div class="bg-green-200 h-[4rem] w-[4rem] rounded-full flex justify-center items-center">
            <UserGroupIcon class="text-green-600" />
          </div>
          <div>
            <p class="text-3xl font-black">{{ dataadmin }}</p>
            <p class="text-sm font-bold text-gray-400">Data Admins</p>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-between mb-6">
        <Link class="mt-2 btn-indigo" :href="route('admin.admin.create')">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Admin</span>
        </Link>
      </div>
      <!-- <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" v-model="search" />
      </div> -->
      <div class="bg-white rounded-md shadow">
        <div class="w-full py-2">
          <InputLabel for="search" value="Search" />
          <TextInput type="text" class="w-full" v-model="search" />
        </div>
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Name</th>
              <th class="px-6 pt-6 pb-4">Email</th>
              <th class="px-6 pt-6 pb-4">Number</th>
              <th class="px-6 pt-6 pb-4">Role</th>
              <th class="px-6 pt-6 pb-4">Status</th>
              <th class="px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="admin in adminsList" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(admin.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ admin.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ admin.email }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ admin.number }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p class="px-2 text-sm rounded-xl">{{ adminRole(admin.role) }}</p>
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p class="px-2 text-sm rounded-xl">{{ adminStatus(admin.active) }}</p>
                </p>
              </td>
              <td class="border-t">
                <div class="flex gap-2">
                  <Link :href="route('admin.admin.edit', { admin: admin })"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">
                  <p>Edit</p>
                  </Link>
                  <button v-if="admin.active === 0" @click="update(admin, 1)"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</button>
                  <button v-if="admin.active === 1" @click="update(admin, 0)"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Deactivate</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="adminsList" @pagination-change-page="getAdmins" />
      </div>
    </div>
  </AdminLayout>
</template>
