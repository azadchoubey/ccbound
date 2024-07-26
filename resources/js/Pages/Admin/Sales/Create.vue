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
    <AdminLayout title="Create">
        <div class="px-[2rem]">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">Add admin</p>
                <form>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" required autofocus />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" required autofocus />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="number" value="Number" />
                            <TextInput id="number" type="text" class="mt-1 block w-full" required autofocus />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>
                        <div>
                            <InputLabel for="role" value="Role" />
                            <select class="w-full border border-gray-200 rounded-lg mt-1">
                                <option value="super_admin">Super Admin</option>
                                <option value="accounts_admin">Accounts Admin</option>
                                <option value="sales_admin">Sales Admin</option>
                                <option value="data_admin">Data Admin</option>
                            </select>
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
