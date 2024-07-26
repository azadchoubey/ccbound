<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import DialogModal from "@/Components/DialogModal.vue";
import { ref } from "vue";
import TextInput from "../Components/TextInput.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";
import axios from "axios";
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
    wallet: Object,
    transactions: Object,
});

const page = usePage();

const showModal = ref(false);
const amount = ref(0);

const showLoader = ref(false);
const order = ref(null);

const submit = () => {
    if (amount.value === 0) {
        return;
    }

    showLoader.value = true;

    axios
        .post(route("payment.create", { amount: amount.value }))
        .then((res) => {
            console.log(res);
            order.value = res.data
            makePayment(res.data.order_id);
            showLoader.value = false;
        })
        .catch((err) => {
            console.log(err);
            showLoader.value = false;
        });
};

const makePayment = (orderId) => {
    var options = {
        "key": "rzp_test_NASH81tY9JXpse",
        "amount": amount.value,
        "currency": "INR",
        "name": "CCBOND",
        "description": "Add Money to Wallet",
        "image": "",
        "order_id": orderId,
        "handler": function (response) {
            var razorpay_payment_id = response.razorpay_payment_id;
            var razorpay_order_id = response.razorpay_order_id;
            var razorpay_signature = response.razorpay_signature;
            console.log(razorpay_order_id)
            console.log(razorpay_payment_id)
            console.log(razorpay_signature)
            axios.post('/payment/verify', {
                razorpay_payment_id: razorpay_payment_id,
                razorpay_order_id: razorpay_order_id,
                razorpay_signature: razorpay_signature,
                user_id: page.props.value.user.id
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    var data = response.data;
                    if (data === 1) {
                        alert('Payment Success');
                    } else {
                        alert('Payment Failed');
                    }
                    window.location.reload();
                })
                .catch(function (error) {
                    console.error("Error in Axios request:", error);
                });

        },
        "prefill": {
            "name": page.props.value.user.name,
            "email": page.props.value.user.email,
            "contact": page.props.value.user.number
        },
        "notes": {
            "address": 'a'
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function (response) {
        // alert(response.error.code);
        // alert(response.error.description);
        // alert(response.error.source);
        // alert(response.error.step);
        // alert(response.error.reason);
        // alert(response.error.metadata.order_id);
        // alert(response.error.metadata.payment_id);
    });

    rzp1.open();
}
</script>

<template>
    <AppLayout title="Wallet">
        <div class="p-2">
            <div
                class="flex flex-col justify-between bg-gradient-to-r to-green-700 from-green-900 h-[12rem] rounded-2xl p-3">
                <p class="text-white">Your earned money</p>
                <p class="text-4xl font-bold text-white">
                    ₹ {{ wallet.amount }}
                </p>
                <div class="flex gap-2">
                    <Link :href="route('subscription.create')" class="px-6 py-3 bg-white rounded-2xl">
                    Subscribe
                    </Link>
                    <Link :href="route('payout')" class="px-6 py-3 text-white bg-black rounded-2xl">
                    Payout
                    </Link>
                    <button @click="showModal = !showModal" :href="route('subscription.create')"
                        class="px-6 py-3 bg-white rounded-2xl">
                        Add Money
                    </button>
                </div>
            </div>

            <DialogModal :show="showModal" @close="showModal = !showModal">
                <template #content>
                    <div class="flex justify-center w-full mt-4">
                        <p class="text-lg font-bold">Enter the Amount:</p>

                        <TextInput id="amount" v-model="amount" type="number" class="block w-full mt-1" />
                    </div>
                    <div class="flex justify-end mt-10">
                        <PrimaryButton @click="submit">Submit</PrimaryButton>
                    </div>
                    <div v-if="showLoader" class="flex justify-center mt-10">
                        <div type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-6 text-white transition duration-150 ease-in-out bg-black rounded-md shadow cursor-not-allowed"
                            disabled="">
                            <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing...
                        </div>
                    </div>
                </template>
                <template #footer>
                    <SecondaryButton @click="showModal = !showModal">
                        Ok
                    </SecondaryButton>
                    <SecondaryButton @click="showModal = !showModal">
                        Cancel
                    </SecondaryButton>
                </template>
            </DialogModal>

            <div class="p-3 mt-2 bg-white rounded-lg">
                <p>People joined through your link</p>
                <div class="mt-2">
                    <Link :href="route('refer.show')" class="px-4 py-2 mt-3 text-white bg-black rounded-xl">View</Link>
                </div>
            </div>

            <!-- <div class="p-3 mt-2 bg-white rounded-lg">
                <p>People purchased product upload pack</p>
                <div class="mt-2">
                    <Link :href="route('buy.show')" class="px-4 py-2 mt-3 text-white bg-black rounded-xl">View</Link>
                </div>
            </div> -->

            <!-- component -->
            <section class="container mx-auto mt-3 font-mono">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr
                                    class="font-semibold tracking-wide text-left text-gray-900 uppercase bg-gray-100 border-b border-gray-600 text-md">
                                    <th class="px-4 py-3">Transaction</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Amount</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="transaction in transactions" class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        {{ transaction.for }}
                                    </td>
                                    <td class="px-4 py-3 border">
                                        {{ transaction.type }}
                                    </td>
                                    <td class="px-4 py-3 text-xs border">
                                        {{ transaction.amount }}
                                    </td>
                                    <td class="px-4 py-3 text-sm border">
                                        {{
                                            transaction.created_at.slice(0, 10)
                                        }}
                                    </td>
                                    <td class="px-4 py-3 text-sm border">
                                        {{ transaction.status }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
