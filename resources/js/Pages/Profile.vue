<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios, { formToJSON } from "axios";
import { ref, watch } from "vue";
import ChemicalDetailsCard from "../components/ChemicalDetailsCard.vue";
import InfiniateScroll from "../Components/InfiniateScroll.vue";
import TextInput from "../components/TextInput.vue";
import ArrowRight from "../Icons/ArrowRightIcon.vue";
import ProfieLayout from "../Layouts/ProfileLayout.vue";
import DialogModal from "../Components/DialogModal.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  profile: Object,
  enquiries: Object,
  sales: Object,
  products: Object,
  authID: Number
});

const tab = ref("enquiry");
const id = props.authID;

const enquiriesList = ref(props.enquiries)
const salesList = ref(props.sales)
const productsList = ref(props.products)

const form = useForm({});

const setTab = (tabValue) => {
  tab.value = tabValue;
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

const updateEnquiry = (enquiry, status) => {
  if (confirm("Are you sure?")) {
    axios.post(route('enquiry.update', { type: 'status_update', enquiry: enquiry, status: status }))
      .then(res => {
        window.location.reload();
      })
  }
}

const deleteEnquiry = (enquiry) => {
  if (confirm("Are you sure?")) {
    form.delete(route('enquiry.destroy', { enquiry: enquiry }), {
      onFinish: () => window.location.reload(),
    })

  }
}

let showSaleDelete = ref(false)
let showProductDelete = ref(false)

let searchQuery = ref(null);

let showShareMessage = false;

let sale_id = ref(null);
let product_id = ref(null);

let index = ref(null);

const openModal = (id, idx, modalType) => {
  index.value = idx;
  
  if (modalType == 'sale') {
    sale_id.value = id;
    showSaleDelete.value = true;
  }

  if (modalType == 'product') {
    product_id.value = id;
    showProductDelete.value = true;
  }
  
}

const closeModal = () => {
  showProductDelete.value = false;
  showSaleDelete.value = false;
  sale_id.value = null;
  product_id.value = null;
  index.value = null;
}


const deleteSale = () => {
  salesList.value.data.splice(index.value, 1);
  showSaleDelete.value = false;
  
  axios.delete(`/sales/${sale_id.value}`).then(res => {
    product_id.value = null;
    sale_id.value = null;
    index.value = null;
    
  })
}

const deleteProduct = () => {
  productsList.value.data.splice(index.value, 1);
  showProductDelete.value = false;
  
  axios.delete(`/product/${product_id.value}`).then(res => {
    product_id.value = null;
    sale_id.value = null;
    index.value = null;
    
  })
}


const updateSale = (sale, status) => {
  if (confirm("Are you sure?")) {
    axios.post(route('sale.update', { type: 'status_update', sale: sale, status: status }))
      .then(res => {
        window.location.reload();
      })
  }
}

const shareToSales = (product) => {
  if (confirm('Are you sure?')) {
    axios.post(route('product.share', { product: product }))
      .then(res => {
        if (res.status === 200) {
          alert('Product shared to sales')
          window.location.reload();
        }
      })
  }
}

watch(searchQuery, async (newSearchQuery, oldSearchQuery) => {
    
    if (newSearchQuery.value !== "") {
      if(tab.value == 'products') {
        axios.get(route("product.index", { search: newSearchQuery }))
            .then((res) => {
                productsList.value = res.data;
            });
      } else if(tab.value == 'sales') {
        axios.get(route("sales.index", { search: newSearchQuery }))
            .then((res) => {
                salesList.value = res.data;
                if (!salesList.value.data.length) {
                    showProducts.value = true;
                }
            });
      } else if(tab.value == 'enquiry') {
        console.log('enter enquiry');
        axios.get(route("enquiry.index", { search: newSearchQuery }))
            .then((res) => {
                enquiriesList.value = res.data;
            });  
            console.log('EXIT =>', enquiriesList);
      }
    } else {
        window.location.reload();
    }

    if (searchQuery.value != "") {
        showShareMessage = true
    } else {
        showShareMessage = false
    }
});

</script>

<template>
  <ProfieLayout title="Profile">
    <div class="h-full md:w-[40rem] lg:w-[40rem] md:mt-2">
      <div class="p-2 bg-white">
        <div class="inline-block rounded-full border-[3px] border-gray-300">
          <img :src="profile.profile_photo_url" alt="profile image" class="h-[7rem] w-[7rem] rounded-full" />
        </div>
        <p class="text-2xl font-bold">{{ profile.name }}</p>
        <p v-if="($page.props.user.id != profile.id) && profile.hide_email === 1">XXXXXXXXXX</p>
        <p v-else>{{ profile.email }}</p>
        <p v-if="($page.props.user.id != profile.id) && profile.hide_number === 1">XXXXXXXXXX</p>
        <p v-else>{{ profile.number }}</p>

        <div class="flex items-center gap-2 mt-2">
          <img :src="profile.company.logo_url" alt="company logo" class="w-[10rem]" />
          <Link :href="route('company.show', { id: profile.company_id })">@{{ profile.company.name }}</Link>
        </div>
        <p class="text-sm">{{ profile.address }}</p>
        <a :href="profile.company.website" target="_blank" class="block text-blue-600">{{ profile.company.website }}</a>

        <Link v-if="profile.canEdit" :href="route('profile.show')"
          class="bg-[#0095F6] text-white flex items-center w-[8rem] px-3 py-2 rounded-lg mb-3">
        <span class="inline-block">Edit Profile</span>
        <ArrowRight class="inline-block" />
        </Link>
      </div>

      <div class="py-4 bg-gray-100">
        <div class="grid grid-cols-3 border-b-[1px] border-gray-200">
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
        </div>
        <div>
          <div class="px-2">
                <TextInput type="text" v-model="searchQuery" class="mt-3 block w-full h-[2.5rem] p-1" placeholder="Search Product Name/CAS No" />
            </div>
        </div>
        <!-- <TextInput type="text" class="w-full mt-2" placeholder="Search" /> -->
        <div class="grid grid-cols-1 gap-2 mt-2">
          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'enquiry'" v-for="enquiry in enquiriesList.data">
              <ChemicalDetailsCard :details="enquiry" :link="route('sale.chats.redirect', { enquiry: enquiry.id })"
                :id="id" />
              <div v-if="$page.props.user.id === profile.id"
                class="grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200">
                <Link :href="route('enquiry.edit', { enquiry: enquiry })"
                  class="flex justify-center w-full text-blue-600">
                Edit and Reshare</Link>
                <button @click="deleteEnquiry(enquiry)" class="text-red-600">Delete</button>
                <button v-if="enquiry.approved === 0">Pending</button>
                <button v-if="enquiry.approved === 2">Rejected</button>
                <button v-if="enquiry.approved === 1 && enquiry.status === false"
                  @click="updateEnquiry(enquiry, 'activate')" class="text-green-600">Activate</button>
                <button v-if="enquiry.approved === 1 && enquiry.status === true"
                  @click="updateEnquiry(enquiry, 'deactivate')" class="text-red-600">Deactivate</button>
              </div>
            </div>
          </InfiniateScroll>

          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'sales'" v-for="(sale, index) in salesList.data">
              <ChemicalDetailsCard :details="sale" :link="route('enquiry.chats.redirect', { sale: sale.id })"
                :id="id" />
              <div v-if="$page.props.user.id === profile.id"
                class="grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200">
                <Link :href="route('sale.edit', { sale: sale })" class="flex justify-center w-full text-blue-600">Edit
                and
                Reshare</Link>
                <button class="text-red-600" @click="openModal(sale.id, index, 'sale')">Delete</button>
                <button v-if="sale.approved === 0">Pending</button>
                <button v-if="sale.approved === 2" class="text-red-600">Rejected</button>
                <button v-if="sale.approved === 1 && sale.status === false" @click="updateSale(sale, 'activate')"
                  class="text-green-600">Activate</button>
                <button v-if="sale.approved === 1 && sale.status === true" @click="updateSale(sale, 'deactivate')"
                  class="text-red-600">Deactivate</button>
              </div>
            </div>
          </InfiniateScroll>

          <InfiniateScroll @loadMore="loadMore" class="space-y-4">
            <div v-if="tab === 'products'" v-for="(product, index) in productsList.data">
              <ChemicalDetailsCard :details="product" :link="route('product.chats.redirect', { product: product.id })"
                :id="id" />
              <div v-if="$page.props.user.id === profile.id"
                class="grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200">
                <Link :href="route('product.edit', { product: product })"
                  class="flex justify-center w-full text-blue-600">
                Edit and Reshare</Link>
                <button class="text-red-600" @click="openModal(product.id, index, 'product')">Delete</button>
                <button v-if="product.approved === 0">Pending</button>
                <button @click="shareToSales(product)" v-if="product.approved === 1" class="text-blue-600">Share to
                  sales</button>
                <button v-if="product.approved === 2" class="text-red-600">Rejected</button>
              </div>
            </div>
          </InfiniateScroll>

        </div>
      </div>
    </div>
    <DialogModal :show="showSaleDelete" @close="closeModal">
      <template #content>
        <div class="mt-4">
          <p class="mb-2">Are you sure you want to delete?</p>
        </div>
      </template>
      <template #footer>
      
        <SecondaryButton  @click="deleteSale" >
          Delete
        </SecondaryButton>
      
        <SecondaryButton @click="closeModal">
          Cancel
        </SecondaryButton>
      </template>
    </DialogModal>
    
    <DialogModal :show="showProductDelete" @close="closeModal">
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
  </ProfieLayout>
</template>
