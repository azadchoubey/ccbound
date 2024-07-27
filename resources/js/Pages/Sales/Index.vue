<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/components/TextInput.vue";
import ChemicalDetailsCard from "@/Components/ChemicalDetailsCard.vue";
import DialogModal from "@/components/DialogModal.vue";
import PlusIcon from "../../Icons/PlusIcon.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InfiniateScroll from "@/Components/InfiniateScroll.vue";
import { ref, watch, onMounted } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    sales: Object,
    products: Object,
    countries: Object,
    filterCountry: Object,
    filterCity: Object,
    filterState: Object
});

const showLocation = ref(false);

const searchQuery = ref("");
// console.log(props.sales);
const salesList = ref(props.sales);
const productsList = ref(props.products);
const showProducts = ref(false);
const filterCountry = props.filterCountry;
const filterState = props.filterState;
const filterCity = props.filterCity;

const states = ref(null);
const cities = ref(null);

const country = ref(null);
const state = ref(null);
const city = ref(null);

const params = ref(null);

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
    window.location =
        "/sales?country=" +
        country.value +
        "&state=" +
        state.value +
        "&city=" +
        city.value;
};

const reload = () => {
    window.location = "/sales";
};

onMounted(() => {
    if (!salesList.value.data.length || salesList.value.data.length < 4) {
        showProducts.value = true;
    }
});

const form = useForm({
    message: null,
    sales: ref([]),
    products: ref([]),
});

const loadMore = () => {
    // if (!salesList.value.next_page_url) {
    //     showProducts.value = true;
    //     if (!productsList.value.next_page_url) {
    //         return;
    //     }
    //     return axios.get(productsList.value.next_page_url).then((res) => {
    //         productsList.value = {
    //             ...res.data,
    //             data: [...productsList.value.data, ...res.data.data],
    //         };
    //     });
    // }
    if (salesList.value.next_page_url) {
        return axios.get(salesList.value.next_page_url).then((res) => {
            salesList.value = {
                ...res.data,
                data: [...salesList.value.data, ...res.data.data],
            };
        });
    }
};

let showShareMessage = false;

watch(searchQuery, async (newSearchQuery, oldSearchQuery) => {
    if (newSearchQuery.value !== "") {
        axios
            .get(route("sales.index", { search: newSearchQuery }))
            .then((res) => {
                salesList.value = res.data;
                if (!salesList.value.data.length) {
                    showProducts.value = true;
                }
            });

        // axios
        //     .get(route("product.index", { search: newSearchQuery }))
        //     .then((res) => {
        //         productsList.value = res.data;
        //     });
    } else {
        window.location.reload();
    }

    if (searchQuery.value != "") {
        showShareMessage = true
    } else {
        showShareMessage = false
        form.sales = []
    }
});

const shareMessages = () => {
    if (form.sales.length + form.products.length > 5) {
        alert("You cannot select more than 5");
        return;
    }
    // console.log(form)
    //   return;
    form.post(route("chatroom.sendMessages"), {
        onFinish: () => confirm('Message Sent'),
    });
};

watch(form, async (newValue, oldValue) => {
    if (newValue.sales.length + newValue.products.length > 5) {
        alert("You cannot select more than 5");
    }
});

const selectSale = ref(null);

const selectAll = (e) => {
    if (e.target.checked) {
        salesList.value.data.forEach(sale => {
            form.sales.push(sale.id);
        });
    } else {
        form.sales = []
        selectSale.value = null
    }
}
</script>

<template>
    <AppLayout title="Sales">
        <div class="max-w-[40rem]">
            <div class="flex justify-between px-2 my-3">
                <p class="px-2 text-xl font-semibold">Sales</p>
                <Link :href="route('sales.create')">
                <div class="flex items-center p-1 px-4 py-2 text-white bg-blue-600 rounded-lg">
                    <PlusIcon class="h-[1.3rem]" />
                    <p class="text-sm">Add Sale</p>
                </div>
                </Link>
            </div>
            <div class="px-2">
                <TextInput type="text" v-model="searchQuery" class="mt-1 block w-full h-[2.5rem] p-1" placeholder="Search Product Name/CAS No" />
            </div>

            <div class="flex justify-end w-full px-2 py-1">
                <span class="mt-2 mr-3 text-blue-400">{{ filterCity ? filterCity.name.toUpperCase() : '' }}</span>
                <span class="mt-2 mr-3 text-blue-400">{{ filterState ? filterState.name.toUpperCase() : '' }}</span>
                <span class="mt-2 mr-3 text-blue-400">{{ filterCountry ? filterCountry.name.toUpperCase() : '' }}</span>
                <button @click="showLocation = true" class="p-1 px-4 py-1 text-sm text-white bg-blue-600 rounded-lg">
                    Filter Location

                </button>
            </div>

            <div class="my-5" v-if="showShareMessage">
                <p class="text-xl font-bold">Share message</p>
                <form @submit.prevent="shareMessages">
                    <textarea class="w-full rounded-lg focus:outline-none" v-model="form.message" required></textarea>
                    <div class="flex justify-end w-full">
                        <PrimaryButton class="px-4 py-2 text-sm text-white bg-blue-600 border-blue-600 rounded-lg">Share
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <div class="flex flex-col gap-2 px-2">
                <p class="text-xl font-bold">Sales</p>
                <InfiniateScroll @loadMore="loadMore" class="space-y-4">
                    <input type="checkbox" class="block mb-5" value="0" v-model="selectSale" v-if="showShareMessage"
                        @change="selectAll" />
                    <div v-for="sale in salesList.data" class="flex w-full gap-2">
                        <input type="checkbox" class="block" :value="sale.id" v-model="form.sales"
                            v-if="showShareMessage" />
                        <ChemicalDetailsCard :details="sale" :id="'SLE' + sale.id" :link="route('enquiry.chats.redirect', {
                                sale: sale.id,
                            })
                        " />
                    </div>
                </InfiniateScroll>

                <!-- <p v-if="showProducts" class="text-xl font-bold">Supplies</p> -->
                <!-- <InfiniateScroll @loadMore="loadMore" class="space-y-4">
                    <div v-for="product in productsList.data" class="flex w-full gap-2">
                        <input type="checkbox" class="block" :value="product.id" v-model="form.products" />
                        <div class="flex-1 w-full">
                            <ChemicalDetailsCard :details="product" :id="'PRD' + product.id" :link="route('product.chats.redirect', {
                                product: product.id,
                            })" class="flex-1 w-full" />
                        </div>
                    </div>
                </InfiniateScroll> -->
            </div>
        </div>

        <DialogModal :show="showLocation" @close="showLocation = false">
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
