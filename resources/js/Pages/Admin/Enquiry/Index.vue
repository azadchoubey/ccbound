<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { ref, watch } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { formatDate } from "../../../Helpers/helpers";
import axios from "axios";
import DialogModal from "../../../Components/DialogModal.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  enquiries: Object,
});

let showPeople = ref(false)
const enquiriesList = ref(props.enquiries)

const approved = ref(null);

let enquiry_id = ref(null);
let index = ref(null);

const openModal = (id, idx) => {
  showPeople.value = true;
  enquiry_id.value = id;
  index.value = idx;
}

const closeModal = () => {
  showPeople.value = false
}

const applyFilter = () => {
  if (approved.value != null) {
    getEnquiries();
  }
};

const update = (enquiry, status, active) => {
  axios.post(route('admin.enquiry.updateStatus', { enquiry: enquiry, status: status, active: active }))
    .then(res => {
      if (res.status === 200) {
        window.location.reload()
      }
    })
}


const getEnquiries = (page = 1) => {
  enquiriesList.value = [];
  axios.get(route('admin.enquiry.index', { page: page, approved: approved.value }))
    .then(res => {
      enquiriesList.value = res.data
    })
}

const deleteEnquiry = () => {
  
  showPeople.value = false;
  enquiriesList.value.data.splice(index.value, 1);
  axios.delete(`enquiries/${enquiry_id.value}`).then(res => {
    enquiry_id.value = null;
    index.value = null;
    
  });
}

const search = ref();

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.enquiry.index', { search: newSearchQuery })).then(res => {
      enquiriesList.value = res.data
    })
  } else {
    window.location.reload()
  }
})

</script>

<template>
  <AdminLayout title="Enquiries">
    <div class="p-[1rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" v-model="search" />
      </div>
      <!-- <div class="flex items-center gap-2 mb-5">
        <select v-model="approved" class="border border-gray-300 rounded-md ">
          <option value="" selected disabled>Select Filter</option>
          <option value="0">Pending</option>
          <option value="1">Approved</option>
          <option value="2">Rejected</option>
        </select>
        <PrimaryButton @click="applyFilter">Filter</PrimaryButton>
      </div> -->
      <div class="overflow-auto bg-white rounded-md shadow">
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
            <tr v-for="(enquiry, index) in enquiriesList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{
          enquiry.updated_at ? formatDate(enquiry.created_at.slice(0, 10)) : '' }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ 'ENQ' + enquiry.id }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ enquiry.user?.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ enquiry.product_name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ enquiry.cas_no }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold" v-if="formatDate(enquiry.expiry_date) != '01 Jan 1970'">{{ formatDate(enquiry.expiry_date) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p v-if="enquiry.approved === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Pending
                </p>
                <p v-if="enquiry.approved === 1 && enquiry.active === 1" class="px-2 text-sm text-green-600 bg-green-200 rounded-xl">Approved
                </p>
                <p v-else-if="enquiry.approved === 1 && enquiry.active === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Disapproved
                </p>
                <p v-if="enquiry.approved === 2" class="px-2 text-sm bg-red-200 text-redd-600 rounded-xl">Rejected</p>
                </p>
              </td>
              <td class="border-t">
                <div class="flex gap-2">
                  <a :href="route('enquiry.show', { enquiry: enquiry })" target="_blank"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">
                    <p>View</p>
                  </a>
                  <button @click="update(enquiry, 1, 1)" v-if="enquiry.approved === 0 || enquiry.approved === 2"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Approve</button>
                  <button @click="update(enquiry, 2, 0)" v-if="enquiry.approved === 0 || enquiry.approved === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Reject</button>
                  <button @click="update(enquiry, 1, 1)" v-if="enquiry.approved === 1 && enquiry.active === 0"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</button>
                  <button @click="update(enquiry, 1, 0)" v-if="enquiry.approved === 1 && enquiry.active === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">De Active</button>
                  <button @click="openModal(enquiry.id, index)"
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
          <SecondaryButton @click="deleteEnquiry">
            Delete
          </SecondaryButton>
          <SecondaryButton @click="closeModal">
            Cancel
          </SecondaryButton>
        </template>
      </DialogModal>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="enquiriesList" @pagination-change-page="getEnquiries" />
      </div>
    </div>
  </AdminLayout>
</template>
