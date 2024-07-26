<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { ref } from 'vue';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  list: Object,
});

const productsList = ref(props.list)

const getList = (page = 1) => {
  axios.get(route('admin.uploadpack.showlist', { page: page }))
    .then(res => {
      productsList.value = res.data
    })
}
</script>

<template>
  <AdminLayout title="Buy Upload Pack List">
    <div class="px-[2rem]">
      <!-- <div class="w-full py-2">
          <InputLabel for="search" value="Search" />
          <TextInput type="text" class="w-full" />
        </div> -->
      <div class="bg-white rounded-md shadow mt-2">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="text-left font-bold">
              <th class="pb-4 pt-6 px-6">Date</th>
              <th class="pb-4 pt-6 px-6">User</th>
              <th class="pb-4 pt-6 px-6">Total Products</th>
              <th class="pb-4 pt-6 px-6">Products Uploaded</th>
              <th class="pb-4 pt-6 px-6">Products Left</th>
              <th class="pb-4 pt-6 px-6">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="list in productsList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ list.created_at.slice(0, 10) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ list.user.name }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ list.total_products }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ list.products_uploaded }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ list.products_left }}</p>
              </td>
              <td class="border-t">
                <Link :href="route('admin.product.create', { user: list.user.id, pack: list.id })"
                  class="flex items-center gap-1 py-1 text-sm text-slate-900 font-bold">
                <p>Upload</p>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="productsList" @pagination-change-page="getList" />
      </div>
    </div>
  </AdminLayout>
</template>
