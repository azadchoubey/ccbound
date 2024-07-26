<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from '@/Components/InputLabel.vue';
import { Link, useForm } from "@inertiajs/inertia-vue3";
import ArrowLeftIcon from "../Icons/ArrowLeftIcon.vue";
import TextInput from "../Components/TextInput.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";


const props = defineProps({
    price: Object,
});

const form = useForm({
    products: null,
})
const submit = () => {
    form.post(route('buy.store'));
}
</script>

<template>
    <AppLayout title="Buy upload pack">
        <div class=" bg-white lg:m-3">
            <div class="lg:hidden w-full border-b border-gray-200 py-[1rem] px-[1rem]">
                <Link :href="route('settings')">
                <ArrowLeftIcon />
                </Link>
            </div>
            <div class="px-[2rem] py-[1rem]">
                <div>
                    <p class="text-2xl font-bold">Buy Upload Pack</p>
                </div>
                <p>Price Per Product: Rs. {{ price.price }}/-</p>
                <form @submit.prevent="submit">
                    <div class="mt-2">
                        <InputLabel for="products" value="No. of Products" />
                        <TextInput type="number" min="1" v-model="form.products" required />
                    </div>

                    <p class="text-red-600">{{ $page.props.errors.amount }}</p>
                    <div class="w-full flex justify-center mt-2">
                        <PrimaryButton>Make Payment</PrimaryButton>
                    </div>
                    <!-- <p class="w-full flex justify-center p-2 text-center">*20% will be paid to the referring candidate this can reflect in referred candidate wallet.</p> -->
                </form>
            </div>

        </div>
    </AppLayout>
</template>
