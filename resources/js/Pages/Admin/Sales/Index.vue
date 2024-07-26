<script setup>
import axios from "axios";
import { ref, watch } from "vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from "../../../Helpers/helpers";
import DialogModal from "../../../Components/DialogModal.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  sales: Object,
});

const salesList = ref(props.sales)
// const sales = ref(props.sales)

const update = (sale, status, active) => {
  axios.post(route('admin.sale.updateStatus', { sale: sale, status: status, active: active }))
    .then(res => {
      if (res.status === 200) {
        console.log(res.data)
        // salesList.value = {...res.data,...salesList.value}
        window.location.reload()
      }
    })
}

const getSales = (page = 1) => {
  axios.get(route('admin.sale.index', { page: page }))
    .then(res => {
      console.log(res);
      salesList.value = res.data
    })
}

let showPeople = ref(false)
let sale_id = ref(null);
let index = ref(null);

const openModal = (id, idx) => {
    showPeople.value = true;
    sale_id.value = id;
    index.value = idx;
}

const closeModal = () => {
    showPeople.value = false
}

const deleteSale = () => {
  salesList.value.splice(index.value, 1)
  axios.delete(`sales/${sale_id.value}`).then(res => {
    sale_id.value = null;
    index.value = null;
    showPeople.value = false;
  });
}

const search = ref();

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.sale.index', { search: newSearchQuery })).then(res => {
      salesList.value = res.data
    })
  } else {
    window.location.reload()
  }
})

</script>

<template>
  <AdminLayout title="Sales">
    <div class="p-[1rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" v-model="search" />
      </div>
     
     
      <div class="bg-white rounded-md shadow overfl">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">ID</th>
              <th class="px-6 pt-6 pb-4">User</th>
              <th class="px-6 pt-6 pb-4">Product Name</th>
              <th class="px-6 pt-6 pb-4">CAS No</th>
              <th class="px-6 pt-6 pb-4">Expiry Date</th>
              <th class="px-6 pt-6 pb-4">Status</th>
              <th class="px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(sale, index) in salesList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(sale.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ 'SLE' + sale.id }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold" :href="`/organizations/asdf/edit`">{{
              sale.user?.name
            }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ sale.product_name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ sale.cas_no }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold" v-if="formatDate(sale.expiry_date) != '01 Jan 1970'">{{ formatDate(sale.expiry_date) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p v-if="sale.approved === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Pending</p>
                <p v-if="sale.approved === 1 && sale.active === 1" class="px-2 text-sm text-green-600 bg-green-200 rounded-xl">Approved
                </p>
                <p v-else-if="sale.approved === 1 && sale.active === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Disapproved
                </p>
                <p v-if="sale.approved === 2" class="px-2 text-sm bg-red-200 text-redd-600 rounded-xl">Rejected</p>
                </p>
              </td>
              <td class="border-t">
                <div class="flex gap-2">
                  <a :href="route('sales.show', { sale: sale })" target="_blank"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">
                    <p>View</p>
                  </a>
                  <button @click="update(sale, 1, 1)" v-if="sale.approved === 0 || sale.approved === 2"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Approve</button>
                  <button @click="update(sale, 2, 0)" v-if="sale.approved === 0 || sale.approved === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Reject</button>
                  <button @click="update(sale, 1, 1)" v-if="sale.approved === 1 && sale.active === 0"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</button>
                  <button @click="update(sale, 1, 0)" v-if="sale.approved === 1 && sale.active === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">De Active</button>
                  <button @click="openModal(sale.id, index)"
                   class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Delete</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <DialogModal :show="showPeople" @close="closeModal">
        <template #content>
            <div class="mt-4">
                <p class="mb-2">Are you sure you want to delete?</p>
            </div>
        </template>
        <template #footer>
          <SecondaryButton @click="deleteSale">
          Delete
        </SecondaryButton>
        <SecondaryButton @click="closeModal">
          Cancel
        </SecondaryButton>
      </template>
    </DialogModal>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="salesList" @pagination-change-page="getSales" />
      </div>
    </div>
  </AdminLayout>
</template>
