<script setup>
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { COUNTRIES } from '../../Helpers/countries';

import axios from "axios";
import { ref, watchEffect } from "vue";
const props = defineProps({
    referrer: Object,
    countries: Object,
});
const form = useForm({
    name: "",
    companyName: "",
    logo: null,
    address: null,
    country: "",
    state: "",
    city: "",
    website: "",
    email: "",
    country_code: "",
    number: "",
    password: "",
    password_confirmation: "",
    referrer_id: props.referrer?.id,
    terms: false,
});

const states = ref(null);
const cities = ref(null);

const showPassword = ref(false)
const showConfirmPassword = ref(false)

watchEffect(() => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
            form.state = null;
            form.city = null;
            cities.value = null;
        });
    }
});

watchEffect(() => {
    if (form.state) {
        axios.get(route("cities", { state: form.state })).then((res) => {
            cities.value = res.data.length > 0 ? res.data : null;
        });
    }
});


const submit = () => {
    if(form.country_code) {
        form.number = form.country_code + form.number;
        console.log(form.number);
    }
    
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Full Name*" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="company_name" value="Company Name*" />
                <TextInput
                    id="company_name"
                    v-model="form.companyName"
                    type="text"
                    class="block w-full mt-1"
                    required
                />
                <InputError class="mt-2" :message="form.errors.companyName" />
            </div>

            <div>
                <InputLabel for="company_logo" value="Company Logo(JPG,JPEG,PNG)" />
                <input
                    type="file"
                    name="company_logo"
                    @input="form.logo = $event.target.files[0]"
                    id="company_logo"
                />
                <InputError class="mt-2" :message="form.errors.logo" />
            </div>

            <div>
                <InputLabel for="country" value="Country" />
                <select
                    name="country"
                    id="country"
                    class="w-full rounded-lg"
                    v-model="form.country"
                >
                    <option value="" selected disabled>Select Country</option>
                    <option v-for="country in countries" :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <div v-if="states">
                <InputLabel for="state" value="State" />
                <select
                    name="state"
                    id="state"
                    class="w-full rounded-lg"
                    v-model="form.state"
                    required
                >
                    <option value="" selected disabled>Select State</option>
                    <option v-for="state in states" :value="state.id">
                        {{ state.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.state" />
            </div>

            <div v-if="cities">
                <InputLabel for="city" value="City" />
                <select
                    name="city"
                    id="city"
                    class="w-full rounded-lg"
                    v-model="form.city"
                >
                    <option value="" selected disabled>Select City</option>
                    <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="website" value="Website Url" />
                <TextInput
                    id="website"
                    v-model="form.website"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="website"
                    placeholder="www.example.com"
                />
                <InputError class="mt-2" :message="form.errors.website" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email*" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="block w-full mt-1"
                    required
                    autocomplete="email"
                    placeholder="info@example.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="number" value="Mobile Number*" />
                <select
                    name="country_code"
                    id="country_code"
                    class="w-full rounded-lg"
                    v-model="form.country_code"
                >
                    <option value="" selected disabled>Select Country Code</option>
                    <option v-for="country in COUNTRIES" :value="country.dial_code">
                        {{ country.name }} {{ country.dial_code }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.country_code" />
                <TextInput
                    id="number"
                    v-model="form.number"
                    type="text"
                    class="block w-full mt-1"
                    :placeholder="`${form.country_code}`"
                    required
                />
                <InputError class="mt-2" :message="form.errors.number" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password*" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    :type="showPassword ? 'text':'password'"
                    class="block w-full mt-1"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
                <InputLabel for="password" value="Password should be minimum 8 characters long" />
                <div class="flex items-center gap-2">
                    <input type="checkbox" v-model="showPassword">
                    <p>Show Password</p>
                </div>
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password*"
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :type="showConfirmPassword ? 'text':'password'"
                    class="block w-full mt-1"
                    required
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
                <div class="flex items-center gap-2">
                    <input type="checkbox" v-model="showConfirmPassword">
                    <p>Show Password</p>
                </div>
            </div>

            <div v-if="referrer" class="mt-4">
                <InputLabel for="referrer_name" value="Referrer Name" />
                <TextInput
                    id="referrer_name"
                    :value="referrer.name"
                    type="text"
                    class="block w-full mt-1"
                    required
                />
            </div>

            <div v-if="referrer" class="hidden mt-4">
                <TextInput
                    id="referrer_name"
                    v-model="form.referrer_id"
                    type="text"
                    class="block w-full mt-1"
                    required
                />
            </div>

            <div class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox
                            id="terms"
                            v-model:checked="form.terms"
                            name="terms"
                            required
                        />

                        <div class="ml-2">
                            I agree to the
                            <a
                                :href="route('terms')"
                                class="text-sm text-gray-600 underline hover:text-gray-900"
                                >Terms of Service</a
                            >
                            and
                            <a
                                :href="route('privacy')"
                                class="text-sm text-gray-600 underline hover:text-gray-900"
                                >Privacy Policy</a
                            >
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-600 underline hover:text-gray-900"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ml-4 bg-blue-600"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
