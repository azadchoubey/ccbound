<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref, watch } from "vue";
import { formatDate } from '../../../Helpers/helpers';

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  companies: Object,
});

const companiesList = ref(props.companies)

const getCompanies = (page = 1) => {
  axios.get(route('admin.company.index', { page: page }))
    .then(res => {
      companiesList.value = res.data
    })
}

const search = ref();

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.company.index', { search: newSearchQuery })).then(res => {
      companiesList.value = res.data
    })
  } else {
    window.location.reload()
  }
})

</script>

<template>
  <AdminLayout title="Companies">
    <div class="px-[2rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full"  v-model="search" />
      </div>
     
      <div class="mt-2 bg-white rounded-md shadow">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Company Name</th>
              <th class="px-6 pt-6 pb-4">Website</th>
              <th class="px-6 pt-6 pb-4">Address</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="company in companiesList.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ formatDate(company.created_at.slice(0, 10)) }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  <a :href="route('company.show', { id: company })" target="_blank">
                    {{ company.name }}
                  </a>
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  <a :href="company.website" target="_blank">
                    {{ company.website?.slice(0, 50) }}
                  </a>
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ company.address }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="companiesList" @pagination-change-page="getCompanies" />
      </div>
    </div>
  </AdminLayout>
</template>
