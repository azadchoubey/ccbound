<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

</script>

<template>
    <AdminLayout title="Edit">
        <div class="px-[2rem]">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">Edit Sale</p>
                <form>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="product_name" value="Product Name" />
                            <TextInput id="product_name" type="text" class="mt-1 block w-full" required autofocus />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="casn_no" value="CAS No." />
                            <TextInput id="cas_no" type="text" class="mt-1 block w-full" required />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="quantity_required" value="Quantity Required" />
                            <TextInput id="quantity_required" type="text" class="mt-1 block w-full" />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="purity_required" value="Purity Required" />
                            <TextInput id="purity_required" type="text" class="mt-1 block w-full" />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="structure" value="Structure" />
                            <TextInput id="structure" type="file" class="mt-1 block w-full" />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="structure" value="Structure" />
                            <TextInput id="structure" type="file" class="mt-1 block w-full" />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>

                    </div>
                    <PrimaryButton class="mt-2">
                        Add user
                    </PrimaryButton>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
