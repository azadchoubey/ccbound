<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {COUNTRIES_STATES_CITIES} from '../../../Helpers/countries';
import { computed, watch } from 'vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const form = useForm({
    country: null,
    state: null,
    city: null
})

console.log('COUNTRIES_STATES_CITIES ',COUNTRIES_STATES_CITIES);

let countries = COUNTRIES_STATES_CITIES;
// let states;
// let cities;
 
const states = computed(() => {
    return form.country?.states || [];
});

const cities = computed(() => {
    return form.state?.cities || [];
});

watch(() => form.country, () => {
    form.state = null; // Reset state
}, { immediate: true });

const submit = () => {
    form.country = form.country.name
    form.state = form.state.name
    form.city = form.city.name
    form.post(route('admin.country.store'));
};
</script>

<template>
    <AdminLayout title="Create">
        <div class="px-[2rem]">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">Add Country</p>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <InputLabel for="country" value="Country Name" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.country" required>
                                <option  value="" selected disabled>Select Country</option>
                                <option v-for="country in countries" :value="country">{{country.name}}</option>
                            </select>
                            <!-- <TextInput id="country" type="text" class="block w-full mt-1" v-model="form.country"
                                autofocus /> -->
                            <InputError class="mt-2" :message="form.errors.country" />
                        </div>
                        <div>
                            <InputLabel for="state" value="State" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.state" required>
                                <option selected disabled>Select State</option>
                                <option v-for="state in states" :value="state">{{state.name}}</option>
                            </select>
                            <!-- <TextInput id="state" type="text" class="block w-full mt-1" v-model="form.state" required /> -->
                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>
                        <div>
                            <InputLabel for="city" value="City" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.city" required>
                                <option selected disabled>Select City</option>
                                <option v-for="city in cities" :value="city">{{city.name}}</option>
                            </select>
                            <!-- <TextInput id="city" type="text" class="block w-full mt-1" v-model="form.city" required /> -->
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>

                    </div>
                    <PrimaryButton class="mt-2">
                        Add Country
                    </PrimaryButton>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
