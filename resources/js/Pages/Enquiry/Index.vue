<script setup>
import ChemicalDetailsCard from "@/Components/ChemicalDetailsCard.vue";
import DialogModal from "@/components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref, watch } from "vue";
import InfiniateScroll from "../../Components/InfiniateScroll.vue";
import TextInput from "../../components/TextInput.vue";
import PlusIcon from "../../Icons/PlusIcon.vue";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    enquiries: Object,
    countries: Object,
    filterCountry: Object,
    filterCity: Object,
    filterState: Object
});
const showLocation = ref(false);
const searchQuery = ref("");

const enquiriesList = ref(props.enquiries);

const states = ref(null);
const cities = ref(null);

const country = ref(null);
const state = ref(null);
const city = ref(null);

const params = ref(null)

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
    window.location = "/enquiry?country=" + country.value + "&state=" + state.value + "&city=" + city.value;
};

const reload = () => {
    window.location = "/enquiry";
};

const loadMore = () => {
    if (!enquiriesList.value.next_page_url) {
        return;
    }
    return axios.get(enquiriesList.value.next_page_url).then((res) => {
        enquiriesList.value = {
            ...res.data,
            data: [...enquiriesList.value.data, ...res.data.data],
        };
    });
};

watch(searchQuery, async (newSearchQuery, oldSearchQuery) => {
    if (newSearchQuery.value !== "") {
        axios
            .get(route("enquiry.index", { search: newSearchQuery }))
            .then((res) => {
                enquiriesList.value = res.data;
            });
    } else {
        window.location.reload();
    }
});
</script>

<template>
    <AppLayout title="Enquiry">
        <div class="max-w-[40rem]">
            <div class="flex justify-between px-2 my-3">
                <p class="px-2 text-xl font-semibold">Enquiries</p>
                <Link :href="route('enquiry.create')">
                <div class="flex items-center p-1 px-4 py-2 text-white bg-blue-600 rounded-lg">
                    <PlusIcon class="h-[1.3rem]" />
                    <p class="text-sm">Add Enquiry</p>
                </div>
                </Link>
            </div>
            <div class="px-2">
                <TextInput type="text" v-model="searchQuery" class="mt-1 block w-full h-[2.5rem] p-1"
                    placeholder="Search Product Name/CAS No" />
            </div>

            <div class="flex justify-end w-full px-2 py-1">
                <span class="mt-2 mr-3 text-blue-400">{{ filterCity ? filterCity.name.toUpperCase() : '' }}</span>
                <span class="mt-2 mr-3 text-blue-400">{{ filterState ? filterState.name.toUpperCase() : '' }}</span>
                <span class="mt-2 mr-3 text-blue-400">{{ filterCountry ? filterCountry.name.toUpperCase() : '' }}</span>
                <button @click="showLocation = true" class="p-1 px-4 py-1 text-sm text-white bg-blue-600 rounded-lg">
                    Filter Location
                </button>
            </div>
            <InfiniateScroll @loadMore="loadMore" class="space-y-4">
                <ChemicalDetailsCard v-for="enquiry in enquiriesList.data" :details="enquiry" :id="'ENQ' + enquiry.id"
                    :link="route('sale.chats.redirect', { enquiry: enquiry.id })
                    " />
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
