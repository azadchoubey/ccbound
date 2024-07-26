<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import TableRow from "./Partials/TableRow.vue";
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from "../../../Helpers/helpers";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  payouts: Object,
});

const payoutsList = ref(props.payouts)

const getPayouts = (page = 1) => {
  axios.get(route('admin.payout.index', { page: page }))
    .then(res => {
        console.log('ResData ',res.data);
      payoutsList.value = res.data
    })
}
</script>

<template>
  <AdminLayout title="Payouts">
    <div class="p-[1rem]">
      <!-- <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" />
      </div> -->
      <div class="bg-white rounded-md shadow overfl">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">User</th>
              <th class="px-6 pt-6 pb-4">Amount</th>
              <th class="px-6 pt-6 pb-4">Bank</th>
              <th class="px-6 pt-6 pb-4">Account Number</th>
              <th class="px-6 pt-6 pb-4">IFSC Code</th>
              <th class="px-6 pt-6 pb-4">Wallet (After payout)</th>
              <th class="px-6 pt-6 pb-4">Status</th>
              <th class="flex justify-center px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <TableRow v-for="payout in payoutsList.data" :payout="payout" />
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="payoutsList" @pagination-change-page="getPayouts" />
      </div>
    </div>
  </AdminLayout>
</template>
