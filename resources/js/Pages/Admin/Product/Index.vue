<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { formatDate } from "../../../Helpers/helpers";
import axios from "axios";
import DialogModal from "../../../Components/DialogModal.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  products: Object,
});

const productsList = ref(props.products)

const update = (product, status, active) => {
  axios.post(route('admin.product.updateStatus', { product: product, status: status, active: active }))
    .then(res => {
      if (res.status === 200) {
        console.log(res.data)
        // salesList.value = {...res.data,...salesList.value}
        window.location.reload()
      }
    })
}

const getProducts = (page = 1) => {
  axios.get(route('admin.product.index', { page: page }))
    .then(res => {
      productsList.value = res.data
    })
}

let showPeople = ref(false)
let product_id = ref(null);
let index = ref(null);

const openModal = (id, idx) => {
  showPeople.value = true;
  product_id.value = id;
  index.value = idx;
}

const closeModal = () => {
  showPeople.value = false
}

const deleteProduct = () => {
  productsList.value.splice(index.value, 1);
  axios.delete(`products/${product_id.value}`).then(res => {
    product_id.value = null;
    index.value = null;
    showPeople.value = false;
  })
}

const search = ref();

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.product.index', { search: newSearchQuery })).then(res => {
      productsList.value = res.data
    })
  } else {
    window.location.reload()
  }
})


</script>

<template>
  <AdminLayout title="Products">
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
              <th class="px-6 pt-6 pb-4">Company</th>
              <th class="px-6 pt-6 pb-4">Product Name</th>
              <th class="px-6 pt-6 pb-4">CAS No</th>
              <th class="px-6 pt-6 pb-4">Status</th>
              <th class="px-6 pt-6 pb-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in productsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(product.created_at.slice(0, 10)) }}
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ 'PRD' + product.id }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ product.user?.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ product.user?.company.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ product.product_name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ product.cas_no }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                <p v-if="product.approved === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Pending
                </p>
                <p v-if="product.approved === 1 && product.active === 1" class="px-2 text-sm text-green-600 bg-green-200 rounded-xl">Approved
                </p>
                <p v-else-if="product.approved === 1 && product.active === 0" class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">Disapproved
                </p>
                <p v-if="product.approved === 2" class="px-2 text-sm bg-red-200 text-redd-600 rounded-xl">Rejected</p>
                </p>
              </td>
              <td class="border-t">
                <div class="flex gap-2">
                  <a :href="route('product.show', { product: product })" target="_blank"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">
                    <p>View</p>
                  </a>
                  <button @click="update(product, 1, 1)" v-if="product.approved === 0 || product.approved === 2"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Approve</button>
                  <button @click="update(product, 2, 0)" v-if="product.approved === 0 || product.approved === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Reject</button>
                  <button @click="update(product, 1, 1)" v-if="product.approved === 1 && product.active === 0"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Activate</button>
                  <button @click="update(product, 1, 0)" v-if="product.approved === 1 && product.active === 1"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">De Active</button>
                  <button @click="openModal(product.id, index)"
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
          <SecondaryButton @click="deleteProduct">
            Delete
          </SecondaryButton>
          <SecondaryButton @click="closeModal">
            Cancel
          </SecondaryButton>
        </template>
      </DialogModal>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="productsList" @pagination-change-page="getProducts" />
      </div>
    </div>
  </AdminLayout>
</template>
