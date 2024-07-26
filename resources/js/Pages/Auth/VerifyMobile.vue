<script setup>
import { computed, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import TextInput from "@/components/TextInput.vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from "axios";

const props = defineProps({
    status: String,
});

const form = useForm({
    otp: null,
});

const error = ref(null);
const success = ref(null);

const submit = () => {
    axios.post(route("mobile.verify", { otp: form.otp })).then((res) => {
        if (res.data == 0) {
            error.value = "Invalid Otp";
            success.value = null;
        }

        if (res.data == 1) {
            error.value = null;
            success.value = "Otp Verified";
            setTimeout(() => {
                window.location = "/";
            }, 3000);
        }

        if (res.data == -1) {
            success.value = null;
            error.value = "Otp expired";
        }
    });
};

const sendOtp = () => {
    axios.post(route("send.otp")).then((res) => {
        success.value = "OTP sent to your registered mobile";
        error.value = null;
    });
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <Head title="Mobile Number Verification" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Before continuing, could you verify your mobile number by submitting
            the otp we have just sent you? If you didn't receive the otp, we
            will gladly send you another.
        </div>

        <div
            v-if="verificationLinkSent"
            class="mb-4 font-medium text-sm text-green-600"
        >
            A new otp has been sent to your mobile number which you provided in
            your profile settings.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <TextInput type="text" v-model="form.otp" required />
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Verify
                </PrimaryButton>
            </div>
            <p class="text-red-600 text-sm mt-2">{{ error }}</p>
            <p class="text-green-600 text-sm mt-2">{{ success }}</p>
        </form>

        <form @submit.prevent="sendOtp">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Otp
                </PrimaryButton>

                <div>
                    <Link
                        :href="route('profile.show')"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Edit Profile</Link
                    >

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ml-2"
                    >
                        Log Out
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
