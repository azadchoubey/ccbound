<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ArrowLeftIcon from '@/Icons/ArrowLeftIcon.vue';

const props = defineProps({
    plan: Object,
    accounts: String,
    coupon: Object,
    amount: Number,
    final_amount: Number,
})

const form = useForm({
    plan: props.plan,
    accounts: props.accounts,
    amount: props.amount,
    coupon: props.coupon,
    final_amount: props.final_amount,
})

const submit = () => {
    form.post(route('subscription.walletpay'))
}
</script>

<template>
    <AppLayout title="Subscription">
        <div class="lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]">
            <Link :href="route('settings')">
            <ArrowLeftIcon />
            </Link>
        </div>
        <div class="p-[2rem] bg-white mt-2">
            <div class="border border-gray-200 p-2 rounded-lg">
                <p class="text-2xl font-bold">Confirm Details:</p>
                <p> <span class="font-bold">Plan:</span> ₹ {{ plan.price }} / {{ plan.months }} Months</p>
                <p> <span class="font-bold">Accounts:</span> {{ accounts }}</p>
                <p> <span class="font-bold">amount:</span> ₹ {{ amount }} </p>
                <p v-if="coupon"> <span class="font-bold">Discount:</span> {{ coupon.discount }}</p>
                <p v-if="coupon"> <span class="font-bold">Final Amount:</span> {{ final_amount }}</p>
            </div>

            <form @submit.prevent="submit">
                <input type="hidden" v-model="form.plan">
                <input type="hidden" v-model="form.accounts">
                <input type="hidden" v-model="form.amount">
                <input type="hidden" v-model="form.coupon">
                <input type="hidden" v-model="form.final_amount">
                <PrimaryButton class="mt-2">Pay</PrimaryButton>
            </form>
        </div>
</AppLayout>
</template>
