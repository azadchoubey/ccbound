<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/inertia-vue3';

import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref, watch } from "vue";
import { formatDate } from '../../../Helpers/helpers';
import DialogModal from '../../../Components/DialogModal.vue';
import SecondaryButton from "../../../Components/SecondaryButton.vue";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  countries: Object
});

let countriesList = props.countries

let showPeople = ref(false);
let country_id = ref(null);
let state_id = ref(null);
let city_id = ref(null);
let index = ref(null);

const openModal = (country, state, city, idx) => {
  showPeople.value = true;
  country_id.value = country;
  state_id.value = state;
  city_id.value = city;
  index.value = idx;
}

const closeModal = () => {
  showPeople.value = false
}

const deleteCountry = () => {
  countriesList.data.splice(index.value, 1);

  axios.delete(`/admin/country/delete/${country_id.value}/${state_id.value}/${city_id.value}`)
    .then(res => {
      showPeople.value = false
      country_id.value = null;
      state_id.value = null;
      city_id.value = null;
      index.value = null;
    })
}
const getCountries = (page = 1) => {
  axios.get(route('admin.country.index', { page: page }))
    .then(res => {
      countriesList.value = res.data
    })
}

const search = ref();

watch(search, async (newSearchQuery, oldSearchQuery) => {
  if (newSearchQuery.value !== '') {
    axios.get(route('admin.country.index', { search: newSearchQuery })).then(res => {
      countriesList.value = res.data;
    })
  } else {
    window.location.reload()
  }
})

</script>

<template>
  <AdminLayout title="Countries">
    <div class="flex items-center justify-between mb-6 ml-7">
      <Link class="mt-2 btn-indigo" :href="route('admin.country.create')">
      <span>Add</span>
      <span class="hidden md:inline">&nbsp;Country</span>
      </Link>
    </div>
    <div class="px-[2rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" v-model="search" />
      </div>

      <div class="mt-2 bg-white rounded-md shadow">

        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="font-bold text-left">
              <th class="px-6 pt-6 pb-4">Date</th>
              <th class="px-6 pt-6 pb-4">Country</th>
              <th class="px-6 pt-6 pb-4">State</th>
              <th class="px-6 pt-6 pb-4">City</th>
              <th class="px-6 pt-6 pb-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(city, index) in countriesList?.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">{{ city &&
        city.created_at ? formatDate(city.created_at.slice(0, 10)) : '' }}</p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  {{ city.state && city.state.country ? city.state.country.name : '' }}
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  {{ city.state ? city.state.name : '' }}
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  {{ city?.name }}
                </p>
              </td>
              <td class="border-t">
                <p class="flex items-center px-6 py-4 font-semibold">
                  <button
                    @click="openModal(city.state.country ? city.state.country.id : 0, city.state?.id, city ? city.id : 0, index)"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900">Delete</button>
                </p>
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
          <SecondaryButton @click="deleteCountry">
            Delete
          </SecondaryButton>
          <SecondaryButton @click="closeModal">
            Cancel
          </SecondaryButton>
        </template>
      </DialogModal>
      <div class="flex justify-center mt-2">
        <TailwindPagination :data="countriesList" @pagination-change-page="getCountries" />
      </div>
    </div>
  </AdminLayout>
</template>
