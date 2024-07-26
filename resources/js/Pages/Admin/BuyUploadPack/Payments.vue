<script setup>
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
      <div class="bg-white rounded-md shadow mt-2">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="text-left font-bold">
              <th class="pb-4 pt-6 px-6">Date</th>
              <th class="pb-4 pt-6 px-6">User</th>
              <th class="pb-4 pt-6 px-6">Cost Per Product</th>
              <th class="pb-4 pt-6 px-6">Products</th>
              <th class="pb-4 pt-6 px-6">Payment Method</th>
              <th class="pb-4 pt-6 px-6">Order Id</th>
              <th class="pb-4 pt-6 px-6">Payment Id</th>
              <th class="pb-4 pt-6 px-6">Amount</th>
              <th class="pb-4 pt-6 px-6">Coupon</th>
              <th class="pb-4 pt-6 px-6">Discount</th>
              <th class="pb-4 pt-6 px-6">Final Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in paymentsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.created_at.slice(0, 10) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.user.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.cost_per_product }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.products }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.method }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.order_id }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.payment_id }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">₹ {{ payment.amount }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.coupon }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ payment.discount }} %</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">₹ {{ payment.final_amount }}</p>
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
