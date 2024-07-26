<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AdminLayout from "../../../Layouts/AdminLayout.vue";
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AdminLayout title="Create">
        <div class="px-[2rem] bg-gray-100">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">Add admin</p>
                <form @submit.prevent="addEnquiry">
                    <div class="mb-2">
                        <InputLabel for="product_name" value="Product Name" />
                        <TextInput id="product_name" type="text" class="mt-1 block w-full" required />
                        <!-- <InputError class="mt-2" :message="form.errors.productName" /> -->
                    </div>

                    <div class="mb-2">
                        <InputLabel for="cas_no" value="Cas No" />
                        <TextInput id="cas_no" type="text" class="mt-1 block w-full" required />
                        <!-- <InputError class="mt-2" :message="form.errors.casNo" /> -->
                    </div>

                    <InputLabel for="structure" value="Structure" />
                    <input type="file" name="structure" id="structure">

                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="campaign" id="campaign">
                            <label for="sales">Campaign</label>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="radio" name="campaign" id="campaign">
                            <label for="sales">Regular</label>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 items-center gap-4 my-2">
                        <div>
                            <InputLabel for="purity_required" value="Description" />
                            <textarea type="text" class="mt-1 block w-full"></textarea>
                            <!-- <InputError class="mt-2" :message="form.errors.purityRequired" /> -->
                        </div>

                        <div>
                            <InputLabel for="purity_required" value="Category" />
                            <select name="" id="">
                                <option value="">API</option>
                                <option value="">API INTERMEDIATE</option>
                                <option value="">FINE CHEMICAL</option>
                                <option value="">API IMPURITY</option>
                                <option value="">CRO MOLECULE</option>
                                <option value="">SPECIALITY CHEMICAL</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel for="purity_required" value="Category (If not in the list)" />
                            <TextInput id="cas_no" type="text" class="mt-1 block w-full" required />
                            <!-- <InputError class="mt-2" :message="form.errors.casNo" /> -->
                        </div>
                        <div>
                            <InputLabel for="docs" value="Docs" />
                            <input type="file" name="docs" id="docs">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="country" value="Country" />
                            <select class="w-full rounded-lg border border-gray-200">
                                <option value="">India</option>
                            </select>
                            <!-- <InputError class="mt-2" :message="form.errors.quote" />/ -->
                        </div>

                        <div>
                            <InputLabel for="people" value="State" />
                            <select class="w-full rounded-lg border border-gray-200">
                                <option value="">Telangana</option>
                            </select>
                            <!-- <InputError class="mt-2" :message="form.errors.quote" /> -->
                        </div>

                        <div>
                            <InputLabel for="people" value="City" />
                            <select class="w-full rounded-lg border border-gray-200">
                                <option value="">Hyderabad</option>
                            </select>
                            <!-- <InputError class="mt-2" :message="form.errors.quote" /> -->
                        </div>

                    </div>

                    <button
                        class="mt-4 w-full flex justify-center rounded-lg bg-green-300 text-green-500 font-bold p-2 mb-[5rem]">Submit</button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
