<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import ArrowLeftIcon from "@/Icons/ArrowLeftIcon.vue";
import axios from "axios";
import { ref, watch } from "vue";

const props = defineProps({
    company: Object,
    accountsUsed: Number,
    subscriptions: Object,
});

const couponData = ref(null);
const totalAmount = ref(0);

const form = useForm({
    plan: null,
    accounts: null,
    coupon: null,
    amount: null,
});

const expired = () => {
    let today = new Date().toISOString().slice(0, 10);
    let expiry = new Date(props.company.subscription.end_date)
        .toISOString()
        .slice(0, 10);
    if (expiry < today) {
        return "Subscription Pack expired";
    }
    return false;
};

const validateCoupon = () => {
    if (!form.coupon) {
        return;
    }

    if (!form.plan) {
        alert("select a plan");
        return;
    }

    if (!form.accounts) {
        alert("enter accounts");
        return;
    }
    axios.get(route("coupon.validate", { coupon: form.coupon })).then((res) => {
        if (res.data === 0) {
            alert('Invalid Coupon Code');
        }
        couponData.value = res.data;
        calculateTotalAmount();
    });
};

watch([form], () => {
    calculateTotalAmount();
});

const calculateTotalAmount = () => {
    if (!form.plan) {
        return;
    }

    if (!form.accounts) {
        return;
    }
    let calculatedTotalAmount = form.plan.price * form.accounts;

    if (couponData && couponData?.value && couponData?.value?.discount) {
        calculatedTotalAmount = calculatedTotalAmount - (calculatedTotalAmount * (couponData?.value?.discount / 100));
    }

    totalAmount.value = calculatedTotalAmount;
};

const submit = () => {
    form.get(route("subscription.store"));
};
</script>

<template>
    <AppLayout title="Subscription">
        <div class="lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]">
            <Link :href="route('settings')">
            <ArrowLeftIcon />
            </Link>
        </div>
        <div class="p-[2rem] bg-white mt-2">
            <div class="py-4">
                <p class="text-2xl font-bold">Your current plan</p>
                <div>
                    <div class="w-full border border-gray-200 rounded-lg p-3">
                        <div v-if="company.subscription.subscription ===
                            '#SUB000000'
                            " class="w-full text-lg font-semibold">
                            Trail
                        </div>

                        <div v-if="company.subscription.subscription !==
                            '#SUB000000'
                            " class="w-full text-lg font-semibold">
                            ₹ {{ company.subscription.amount }} / {{ company.subscription.months }} Months
                        </div>
                        <p>Accounts: {{ company.subscription.accounts }}</p>
                        <p>No. of accounts used: {{ accountsUsed }}</p>
                        <p>Expiry date: {{ company.subscription.end_date }}</p>
                        <p v-if="expired()" class="text-red-600 text-sm">
                            Your Subscription pack expired
                        </p>
                    </div>
                </div>
            </div>
            <form @submit.prevent="submit">
                <div>
                    <p class="text-xl font-bold">Select your plan</p>
                </div>
                <!-- plan  -->
                <div>
                    <h3 class="mb-2 text-base font-medium text-gray-900 dark:text-white">
                        How much do you expect to use each month?
                    </h3>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <div v-for="subscription in subscriptions" class="flex items-center gap-2">
                            <input type="radio" name="plan" :value="subscription" v-model="form.plan" required />
                            <div
                                class="w-full h-full flex items-center px-2 py-4 font-semibold text-lg border border-gray-200 rounded-lg">
                                ₹ {{ subscription.price }} /
                                {{ subscription.months }} Months
                            </div>
                        </div>
                    </ul>
                </div>

                <p class="text-red-600">{{ $page.props.errors.plan }}</p>

                <!-- team  -->
                <div class="mt-5">
                    <InputLabel for="accounts" value="No. of accounts" />
                    <TextInput type="number" placeholder="Enter your no. of accounts" min="1" class="mt-1 block w-full"
                        v-model="form.accounts" required />
                </div>
                <div class="mt-5">
                    <InputLabel for="coupon" value="Coupon code" />
                    <div class="flex items-center gap-2">
                        <TextInput id="coupon" type="text" class="mt-1 block w-full" v-model="form.coupon" />
                        <PrimaryButton type="button" @click="validateCoupon">Validate</PrimaryButton>
                    </div>
                </div>
                <p class="text-red-600">{{ $page.props.errors.coupon }}</p>

                <div class="mt-10">
                    <p>
                        <span class="font-bold">Total Amount:</span> Rs.{{ totalAmount }}/-
                    </p>
                </div>
                <p class="text-red-600">{{ $page.props.errors.amount }}</p>

                <div class="w-full flex justify-center mt-2">
                    <button class="text-sm bg-blue-700 px-2 py-3 rounded-lg text-white">
                        Make Payment
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
