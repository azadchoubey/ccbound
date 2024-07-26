<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/inertia-vue3';

import { ref } from "vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const page = usePage();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false)

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required autofocus />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                    class="block w-full mt-1" required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
                <div class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <Checkbox v-model:checked="showPassword" name="showPassword" />
                        <p>Show Password</p>
                    </div>
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-gray-600 underline hover:text-gray-900">
                Forgot your password?
                </Link>

                <PrimaryButton class="ml-4 bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
            <div class="w-full flex justify-center border-t-[1px] border-gray-200 mt-2 py-2">
                <p>Don't have an account? </p>
                <Link :href="route('register')" class="underline"> Register </Link>

            </div>
            <p class="text-center">For Any information write a email to Our Customer Care Email <a
                    href="mailto:info@ccbond.app" class="underline">info@ccbond.app</a></p>
        </form>
    </AuthenticationCard>
</template>
