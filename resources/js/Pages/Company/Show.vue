<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import TextInput from '@/Components/TextInput.vue';
import ChemicalDetailsCard from "../../components/ChemicalDetailsCard.vue";
import ArrowRight from "../../Icons/ArrowRightIcon.vue";
import ProfieLayout from "../../Layouts/ProfileLayout.vue";
import InfiniateScroll from "@/Components/InfiniateScroll.vue";
import axios from "axios";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  company: Object,
  employees: Object,
  enquiries: Object,
  sales: Object,
  products: Object,
});


const enquiriesList = ref(props.enquiries)
const salesList = ref(props.sales)
const productsList = ref(props.products)
const employeesList = ref(props.employees);

let searchQuery = ref(null);

const tab = ref("enquiry");

const setTab = (tabValue) => {
  tab.value = tabValue;
  searchQuery.value = null
};


const loadMore = () => {
  if (!enquiriesList.value.next_page_url) {
    return
  }
  return axios.get(enquiriesList.value.next_page_url, { tab: tab })
    .then(res => {
      if (tab === 'enquiry') {
        enquiriesList.value = {
          ...res.data,
          data: [
            ...enquiriesList.value.data, ...res.data.data
          ]
        }
      }
      else if (tab === 'sales') {
        salesList.value = {
          ...res.data,
          data: [
            ...salesList.value.data, ...res.data.data
          ]
        }
      }
      else if (tab === 'products') {
        productsList.value = {
          ...res.data,
          data: [
            ...productsList.value.data, ...res.data.data
          ]
        }
      }

    })
}

watch(searchQuery, async (newSearchQuery, oldSearchQuery) => {
  if (searchQuery && searchQuery.value !== "") {
    if (tab.value == 'products') {
      axios.get(route("product.index", { search: searchQuery.value }))
        .then((res) => {
          productsList.value = res.data;
        });
    } else if (tab.value == 'sales') {
      axios.get(route("sales.index", { search: searchQuery.value }))
        .then((res) => {
          salesList.value = res.data;
          if (!salesList.value.data.length) {
            showProducts.value = true;
          }
        });
    } else if (tab.value == 'enquiry') {
      axios.get(route("enquiry.index", { search: searchQuery.value }))
        .then((res) => {
          console.log(res.data);
          enquiriesList.value = res.data;
        });
    } else if (tab.value == 'employees') {
      console.log('employees');
      axios.get(route('company.employees', { search: searchQuery.value }))
        .then((res) => {
          console.log(res.data);
          employeesList.value = res.data
        });
      // axios.get(route("enquiry.index", { search: searchQuery.value }))
      //     .then((res) => {
      //       console.log(res.data);
      //         enquiriesList.value = res.data;
      //     });  
      //     console.log('EXIT =>', enquiriesList);
    }
  } else {
    window.location.reload();
  }
});

const formatUrl = (url) => {
  if (!/^https?:\/\//i.test(url)) {
    return 'http://' + url;
  }
  return url;
}
</script>

<template>
  <ProfieLayout title="Profile">
    <div class="h-full md:w-[40rem] lg:w-[40rem]">
      <div class="px-2 my-2 bg-white md:p-4">
        <div class="grid grid-cols-1 mt-2 lg:grid-cols-2">
          <!-- <img :src="company.logo_url" alt="company logo" class="w-[10rem]" /> -->
          <div class="border-gray-300 rounded-full ">
            <img :src="company.logo_url" alt="company logo" class="h-[7rem] w-[7rem] rounded-full" />
          </div>
          <div>
            <p>{{ company.name }}</p>
            <p class="text-sm">{{ company.address }}</p>
            <a :href="formatUrl(company.website)" target="_blank" class="block text-blue-600">{{ company.website }}</a>

            <Link v-if="company.canEdit" :href="route('company.edit', { company: company })"
              class="bg-[#0095F6] text-white flex items-center w-[5rem] px-4 py-2 rounded-lg mb-3">
            <span class="inline-block">Edit</span>
            <ArrowRight class="inline-block" />
            </Link>
          </div>
        </div>
      </div>

      <div class="py-4 bg-gray-100">
        <div class="grid grid-cols-4 border-b-[1px] border-gray-200">
          <button @click="setTab('enquiry')" :class="`${tab === 'enquiry' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
            <p :class="` ${tab === 'enquiry' ? 'font-bold' : ''
            } w-full flex justify-center`">
              Enquiries
            </p>
          </button>
          <button @click="setTab('sales')" :class="`${tab === 'sales' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
            <p :class="` ${tab === 'sales' ? 'font-bold' : ''} w-full flex justify-center`">
              Sales
            </p>
          </button>
          <button @click="setTab('products')" :class="`${tab === 'products' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
            <p :class="` ${tab === 'products' ? 'font-bold' : ''
            } w-full flex justify-center`">
              Products
            </p>
          </button>
          <button @click="setTab('employees')" :class="`${tab === 'employees' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
            <p :class="` ${tab === 'employees' ? 'font-bold' : ''
            } w-full flex justify-center`">
              Employees
            </p>
          </button>
        </div>
        <div>
          <div class="px-2">
            <TextInput type="text" v-model="searchQuery" class="mt-3 block w-full h-[2.5rem] p-1"
              placeholder="Search Product Name/CAS No" />
          </div>
        </div>
        <!-- <TextInput type="text" class="w-full mt-2" placeholder="Search" /> -->
        <div class="grid grid-cols-1 gap-2 mt-2">
          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'enquiry'" v-for="enquiry in enquiriesList.data">
              <ChemicalDetailsCard :details="enquiry" :link="route('sale.chats.redirect', { enquiry: enquiry.id })" />
            </div>
          </InfiniateScroll>
          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'sales'" v-for="sale in salesList.data">
              <ChemicalDetailsCard :details="sale" :link="route('enquiry.chats.redirect', { sale: sale.id })" />
            </div>
          </InfiniateScroll>

          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'products'" v-for="product in productsList.data">
              <ChemicalDetailsCard :details="product"
                :link="route('product.chats.redirect', { product: product.id })" />
            </div>
          </InfiniateScroll>
        </div>

        <div v-if="tab === 'employees'" class="mt-2">
          <div v-for="employee in employeesList" class="p-2 mt-2 bg-white">
            <div class="flex items-center gap-2">
              <img :src="employee.profile_photo_url" alt="" class="h-[5rem] w-[5rem] rounded-full">
              <div>
                <Link :href="route('profile.display', { id: employee.id })" class="block">{{ employee.name }} </Link>
                <Link :href="route('company.show', { id: employee.company.id })">{{ employee.company.name }}</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ProfieLayout>
</template>
