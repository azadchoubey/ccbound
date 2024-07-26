<script setup>
import { formatDate } from "../../../Helpers/helpers";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { ref } from 'vue';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  payments: Object,
});

const paymentsList = ref(props.payments)
const getPayments = (page = 1) => {
  axios.get(route('admin.payments', { page: page }))
    .then(res => {
      paymentsList.value = res.data
    })
}
</script>

<template>
  <AdminLayout title="Payments">
    <div class="px-[1rem]">
      <div class="mt-2 bg-white rounded-md shadow">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">User</th>
              <th class="px-6 pt-6 pb-4">Subscription</th>
              <th class="px-6 pt-6 pb-4">Accounts</th>
              <th class="px-6 pt-6 pb-4">Amount(After Discount)</th>
              <th class="px-6 pt-6 pb-4">Coupon</th>
              <th class="px-6 pt-6 pb-4">Discount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in paymentsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(payment.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.user.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.subscription }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.accounts }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">₹ {{ payment.amount }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.coupon }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.discount }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="paymentsList" @pagination-change-page="getPayments" />
      </div>
    </div>
  </AdminLayout>
</template>
