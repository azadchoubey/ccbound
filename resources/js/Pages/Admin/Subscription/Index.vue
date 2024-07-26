<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from 'vue';
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from '../../../Helpers/helpers';


const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  subscriptions: Object,
});

const subscriptionsList = ref(props.subscriptions)

const update = (subscription, status) => {
  axios.patch(route('admin.subscription.updateStatus', { subscription: subscription, status: status }))
    .then(res => {
      if (res.status === 200) {
        console.log(res.data)
        window.location.reload()
      }
    })
}

const getSubscriptions = (page = 1) => {
  axios.get(route('admin.subscription.index', { page: page }))
    .then(res => {
      adminsList.value = res.data
    })
}
</script>

<template>
  <AdminLayout title="Subscription">
    <div class="px-[2rem]">
      <div class="flex items-center justify-between mb-6">
        <Link class="mt-2 btn-indigo" :href="route('admin.subscription.create')">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Subscription</span>
        </Link>
      </div>
      <!-- <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" />
      </div> -->
      <div class="bg-white rounded-md shadow">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Subscription Code</th>
              <th class="px-6 pt-6 pb-4">Price</th>
              <th class="px-6 pt-6 pb-4">Duration(months)</th>
              <th class="px-6 pt-6 pb-4">Duration(days)</th>
              <th class="flex justify-center px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subscription in subscriptionsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(subscription.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold" :href="`/organizations/asdf/edit`">{{
                  subscription.code
                }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">₹ {{ subscription.price }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ subscription.months }} Months</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ subscription.days }} Days</p>
              </td>
              <td class="border-t flex gap-2 justify-center items-center pt-2.5">
                <Link :href="route('admin.subscription.edit', { subscription: subscription })"
                  class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Edit</Link>
                <Link v-if="subscription.active === 0" @click="update(subscription, 1)"
                  class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</Link>
                <Link v-if="subscription.active === 1" @click="update(subscription, 0)"
                  class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Deactivate</Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="subscriptionsList" @pagination-change-page="getSubscriptions" />
      </div>
    </div>
  </AdminLayout></template>
