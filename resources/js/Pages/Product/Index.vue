<script setup>
import ChemicalDetailsCard from "@/Components/ChemicalDetailsCard.vue";
import DialogModal from "@/components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref, watch, watchEffect } from "vue";
import InfiniateScroll from "../../Components/InfiniateScroll.vue";
import TextInput from "../../components/TextInput.vue";
import PlusIcon from "../../Icons/PlusIcon.vue";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    products: Object,
    countries: Object,
    filterCountry: Object,
    filterCity: Object,
    filterState: Object
});

const form = useForm({
    message: null,
    sales: ref([]),
    products: ref([]),
});

const showLocation = ref(false);
const searchQuery = ref("");

const showProducts = ref(false);

const productsList = ref(props.products);

const states = ref(null);
const cities = ref(null);

const country = ref(null);
const state = ref(null);
const city = ref(null);

// Get the query string from the URL
const queryString = window.location.search;

// Create a new URLSearchParams object
const urlParams = new URLSearchParams(queryString);

// Get a specific query parameter
const paramCountry = urlParams.get('country');

let showShareMessage = false;

if (paramCountry) {

    if (productsList.value.data.length > 0) {
        showProducts.value = true;
        showShareMessage = true
    } else {
        showProducts.value = false;
        showShareMessage = false
        form.products = []
    }
}

watch(country, async (newValue, oldValue) => {
    axios.get(route("states", { country: newValue })).then((res) => {
        states.value = res.data.length > 0 ? res.data : null;
        cities.value = null;
        state.value = null;
    });
});

watch(state, async (newValue, oldValue) => {
    axios.get(route("cities", { state: newValue })).then((res) => {
        cities.value = res.data.length > 0 ? res.data : null;
    });
});

const filter = () => {
    window.location = "/products?country=" + country.value + "&state=" + state.value + "&city=" + city.value;
};

const reload = () => {
    window.location = "/products";
};

const loadMore = () => {
    if (!productsList.value.next_page_url) {
        return;
    }
    return axios.get(productsList.value.next_page_url).then((res) => {
        productsList.value = {
            ...res.data,
            data: [...productsList.value.data, ...res.data.data],
        };
    });
};

const shareMessages = () => {
    if (form.products.length > 5) {
        alert("You cannot select more than 5");
        return;
    }
    // console.log(form)
    //   return;
    form.post(route("chatroom.sendMessages"), {
        onFinish: () => confirm('Message Sent'),
    });
};

// watch(searchQuery, async (newSearchQuery, oldSearchQuery) => {
//     if (newSearchQuery.value !== "") {
//         axios
//             .get(route("product.index", { search: newSearchQuery }))
//             .then((res) => {
//                 productsList.value = res.data;
//                 if (productsList.value.data.length > 0) {
//                     showProducts.value = true;
//                 } else {
//                     showProducts.value = false;
//                 }

//             });
//     } else {
//         window.location.reload();
//     }

//     if (searchQuery.value != "") {
//         showShareMessage = true

//     } else {
//         showShareMessage = false
//         form.products = []
//     }
// });

const searchProducts = () => {
    if (searchQuery.value !== "") {
        axios
            .get(route("product.index", { search: searchQuery.value }))
            .then((res) => {
                productsList.value = res.data;
                if (productsList.value.data.length > 0) {
                    showProducts.value = true;
                    showShareMessage = true
                } else {
                    showProducts.value = false;
                    showShareMessage = false
                    form.products = []
                }

            });
    } else {
        window.location.reload();
    }

    if (searchQuery.value != "") {
        showShareMessage = true

    } else {
        showShareMessage = false
        form.products = []
    }

}


const selectProduct = ref(null);

const selectAll = (e) => {
    if (e.target.checked) {
        productsList.value.data.forEach(product => {
            form.products.push(product.id);
        });
    } else {
        form.products = []
        selectProduct.value = null
    }
}

</script>

<template>
    <AppLayout title="Products">
        <div class="max-w-[40rem]">
            <div class="flex justify-between px-2 my-3">
                <p class="px-2 text-xl font-semibold" v-if="showProducts"><b>Products</b></p>
                <Link :href="route('product.create')">
                <div class="flex items-center p-1 px-4 py-2 text-white bg-blue-600 rounded-lg">
                    <PlusIcon class="h-[1.3rem] " />
                    <p class="text-sm">Add Product</p>
                </div>
                </Link>
            </div>
            <div class="px-2">
                <div>
                    <p class="mb-5 text-5xl text-center mt-72" v-if="!showProducts"><b>Search <span
                                class="text-blue-400">Products</span></b>
                    </p>
                    <TextInput type="text" v-model="searchQuery" class="block w-full h-12 p-1 rounded-lg"
                        placeholder="Search Product Name/CAS No" />
                    <div :class="`${!showProducts ? 'text-center' : ''}`">
                        <button type="button" class="p-1 px-4 py-1 mt-10 text-white bg-blue-600 rounded-lg"
                            @click="searchProducts">Submit</button>
                        <span class="mt-2 ml-3 mr-3 text-blue-400">{{ filterCity ? filterCity.name.toUpperCase() : ''
                            }}</span>
                        <span class="mt-2 mr-3 text-blue-400">{{ filterState ? filterState.name.toUpperCase() : ''
                            }}</span>
                        <span class="mt-5 ml-3 mr-3 text-blue-400">
                            {{ filterCountry ? filterCountry.name.toUpperCase() : '' }}</span>
                        <button @click="showLocation = true"
                            class="p-1 px-4 py-1 mt-2 text-white bg-blue-600 rounded-lg">
                            Filter Location
                        </button>
                    </div>
                </div>

            </div>
            <!-- <div class="flex justify-end w-full px-2 py-1">
                
            </div> -->
            <div class="my-5" v-if="showShareMessage">
                <p class="text-xl font-bold">Share message</p>
                <form @submit.prevent="shareMessages">
                    <textarea class="w-full rounded-lg focus:outline-none" v-model="form.message" required></textarea>
                    <div class="flex justify-end w-full">
                        <PrimaryButton class="px-4 py-2 text-sm text-white bg-blue-600 border-blue-600 rounded-lg ml">
                            Share
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <input type="checkbox" class="block mb-5" value="0" v-model="selectProduct" v-if="showShareMessage"
                @change="selectAll" />
            <span v-if="showProducts"><b>Results For</b>: {{ searchQuery }}</span>
            <InfiniateScroll @loadMore="loadMore" class="mt-4 space-y-4" v-if="showProducts">
                <div v-for="product in productsList.data" class="flex w-full gap-2">
                    <input type="checkbox" class="block" :value="product.id" v-model="form.products"
                        v-if="showShareMessage" />
                    <ChemicalDetailsCard :details="product" :id="'PRD' + product.id" :link="route('product.chats.redirect', { product: product.id })
                    " />
                </div>
            </InfiniateScroll>
        </div>

        <DialogModal :show="showLocation" @close="showLocation = !showLocation">
            <template #content>
                <div class="mt-4">
                    <p class="mb-2">Change Location</p>
                    <form @submit.prevent="filter">
                        <div class="flex items-center gap-2 mb-2">
                            <select name="country" id="country" class="w-full rounded-lg" v-model="country" required>
                                <option value="" selected disabled>
                                    Select Country
                                </option>
                                <option v-for="country in countries" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                        </div>

                        <div v-if="states" class="flex items-center gap-2 mb-2">
                            <select name="state" id="state" class="w-full rounded-lg" v-model="state">
                                <option value="" selected disabled>
                                    Select State
                                </option>
                                <option v-for="state in states" :value="state.id">
                                    {{ state.name }}
                                </option>
                            </select>
                        </div>

                        <div v-if="cities" class="flex items-center gap-2 mb-2">
                            <select name="city" id="city" class="w-full rounded-lg" v-model="city">
                                <option value="" selected disabled>
                                    Select City
                                </option>
                                <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                </option>
                            </select>
                        </div>
                        <SecondaryButton @click="reload()">
                            Cancel
                        </SecondaryButton>

                        <PrimaryButton class="ml-4"> Submit </PrimaryButton>
                    </form>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>
