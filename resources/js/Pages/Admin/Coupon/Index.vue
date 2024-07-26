<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import TableRow from "./Partials/TableRow.vue";
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref } from 'vue';
import { formatDate } from "../../../Helpers/helpers";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  coupons: Object,
});

const couponsList = ref(props.coupons)
const update = (coupon, status) => {
  axios.patch(route('admin.coupon.updateStatus', { coupon: coupon, status: status }))
    .then(res => {
      window.location.reload();
    })
}

const getCoupons = (page = 1) => {
  axios.get(route('admin.coupon.index', { page: page }))
    .then(res => {
      couponsList.value = res.data
    })
}

</script>

<template>
  <AdminLayout title="Coupon">
    <div class="px-[2rem]">
      <div class="flex items-center justify-between mb-6">
        <Link class="mt-2 btn-indigo" :href="route('admin.coupon.create')">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Coupon</span>
        </Link>
      </div>
      <!-- <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" />
      </div> -->
      <div class="mt-2 bg-white rounded-md shadow">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Coupon code</th>
              <th class="px-6 pt-6 pb-4">Percentage</th>
              <th class="px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="coupon in couponsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(coupon.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ coupon.code }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ coupon.discount }}%</p>
              </td>
              <td class="border-t">
                <div class="flex gap-2">
                  <Link :href="route('admin.coupon.edit', { coupon: coupon })"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Edit</Link>
                  <button v-if="coupon.active === 1" @click="update(coupon, 0)"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Deactivate</button>
                  <button v-if="coupon.active === 0" @click="update(coupon, 1)"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="couponsList" @pagination-change-page="getCoupons" />
      </div>
    </div>
  </AdminLayout>
</template>
