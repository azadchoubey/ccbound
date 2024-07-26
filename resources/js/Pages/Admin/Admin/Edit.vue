<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    admin: Object,
});

const form = useForm({
    name: props.admin.name,
    email: props.admin.email,
    number: props.admin.number,
    role: props.admin.role,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.patch(route('admin.admin.update', { admin: props.admin }))
};
</script>

<template>
    <AdminLayout title="Edit">
        <div class="px-[2rem]">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">Add admin</p>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                autofocus />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div>
                            <InputLabel for="number" value="Number" />
                            <TextInput id="number" type="text" class="mt-1 block w-full" v-model="form.number" required />
                            <InputError class="mt-2" :message="form.errors.number" />
                        </div>
                        <div>
                            <InputLabel for="role" value="Role" />
                            <select class="w-full border border-gray-200 rounded-lg mt-1" v-model="form.role" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="accounts_admin">Accounts Admin</option>
                                <option value="sales_admin">Sales Admin</option>
                                <option value="data_admin">Data Admin</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

                        <div>
                            <InputLabel for="passowrd" value="Password" />
                            <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full"
                                required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div>
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                                class="mt-1 block w-full" required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
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
