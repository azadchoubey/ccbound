<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    companyName: '',
    logo: null,
    address: null,
    country: '',
    state: '',
    city: '',
    website: '',
    email: '',
    number: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" required autofocus
                    autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="company_name" value="Company Name" />
                <TextInput id="name" v-model="form.companyName" type="text" class="block w-full mt-1" required />
                <InputError class="mt-2" :message="form.errors.companyName" />
            </div>

            <div>
                <InputLabel for="company_logo" value="Company Logo" />
                <input type="file" name="company_logo" @input="form.logo = $event.target.files[0]"
                    id="company_logo">
                <InputError class="mt-2" :message="form.errors.logo" />
            </div>

            <div>
                <InputLabel for="country" value="Country" />
                <select name="country" id="country" class="w-full rounded-lg" v-model="form.country" required>
                    <option value="" selected disabled>Select Country</option>
                    <option value="India">India</option>
                </select>
                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <div>
                <InputLabel for="state" value="State" />
                <select name="state" id="state" class="w-full rounded-lg" v-model="form.state" required>
                    <option value="" selected disabled>Select State</option>
                    <option value="Telangana">Telangana</option>
                </select>
                <InputError class="mt-2" :message="form.errors.state" />
            </div>

            <div>
                <InputLabel for="city" value="City" />
                <select name="city" id="city" class="w-full rounded-lg" v-model="form.city" required>
                    <option value="" selected disabled>Select City</option>
                    <option value="Hyderabad">Hyderabad</option>
                </select>
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />
                <TextInput id="name" v-model="form.address" type="text" class="block w-full mt-1" required />
                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="website" value="Website Url" />
                <TextInput id="website" v-model="form.website" type="url" class="block w-full mt-1" required
                    autocomplete="website" />
                <InputError class="mt-2" :message="form.errors.website" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="number" value="Mobile Number" />
                <TextInput id="number" v-model="form.number" type="text" class="block w-full mt-1" required />
                <InputError class="mt-2" :message="form.errors.number" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" type="password" class="block w-full mt-1" required
                    autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="block w-full mt-1" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank"
                                class="text-sm text-gray-600 underline hover:text-gray-900">Terms of Service</a> and <a
                                target="_blank" class="text-sm text-gray-600 underline hover:text-gray-900">Privacy
                                Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="text-sm text-gray-600 underline hover:text-gray-900">
                Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
