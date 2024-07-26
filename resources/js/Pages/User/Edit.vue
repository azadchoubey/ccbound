<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watchEffect } from 'vue';
const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    user: Object,
    countries: Object,
});

const form = useForm({
    name: props.user.name,
    address: props.user.address,
    country: props.user.country,
    state: props.user.state,
    city: props.user.city,
    email: props.user.email,
    number: props.user.number,
    password: null,
    password_confirmation: null,
});

const states = ref(null);
const cities = ref(null);

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

const update = () => {
    form.patch(route("user.update", { user: props.user }), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <AppLayout title="Settings">
        <div class="max-w-3xl bg-white rounded-md mt-5">
            <form @submit.prevent="update">
                <div class="w-full flex justify-center font-bold text-2xl py-3">
                    Edit User
                </div>
                <div class="gap-2 px-4 py-2">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>
                        <div>
                            <InputLabel for="number" value="Number" />
                            <TextInput
                                id="number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.number"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.number"
                            />
                        </div>
                        <div>
                            <InputLabel for="country" value="Country" />
                            <select
                                name="country"
                                id="country"
                                class="w-full border border-gray-200 rounded-lg"
                                v-model="form.country"
                                required
                            >
                                <option name="" id="" selected disabled>
                                    Select Country
                                </option>
                                <option
                                    v-for="country in countries"
                                    :value="country.id"
                                >
                                    {{ country.name }}
                                </option>
                            </select>
                            <InputError
                                class="mt-2"
                                :message="form.errors.country"
                            />
                        </div>
                        <div v-if="states">
                            <InputLabel for="state" value="State" />
                            <select
                                name="state"
                                id="state"
                                class="w-full border border-gray-200 rounded-lg"
                                v-model="form.state"
                                required
                            >
                                <option value="" selected disabled>
                                    Select State
                                </option>
                                <option
                                    v-for="state in states"
                                    :value="state.id"
                                >
                                    {{ state.name }}
                                </option>
                            </select>
                            <InputError
                                class="mt-2"
                                :message="form.errors.state"
                            />
                        </div>
                        <div v-if="cities">
                            <InputLabel for="city" value="City" />
                            <select
                                name="city"
                                id="city"
                                class="w-full border border-gray-200 rounded-lg"
                                v-model="form.city"
                                required
                            >
                                <option value="" selected disabled>
                                    Select City
                                </option>
                                <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                </option>
                            </select>
                            <InputError
                                class="mt-2"
                                :message="form.errors.city"
                            />
                        </div>
                    </div>
                    <div>
                        <InputLabel for="address" value="Address" />
                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.address"
                        />
                    </div>
                    <div>
                        <InputLabel for="password" value="Passowrd" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            autocomplete="new-password"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>
                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password"
                        />
                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="new-password"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>
                </div>
                <div
                    class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100"
                >
                    <button
                        class="text-red-600 hover:underline"
                        tabindex="-1"
                        type="button"
                        @click="destroy"
                    >
                        Delete
                    </button>
                    <SecondaryButton class="btn-indigo ml-auto" type="submit"
                        >Update User</SecondaryButton
                    >
                </div>
            </form>
        </div>
    </AppLayout>
</template>
