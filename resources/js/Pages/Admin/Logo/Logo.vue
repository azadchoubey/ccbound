<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from '@/Components/InputLabel.vue';
import FileInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    logo: Object
});

const form = useForm({
    logo: null
})

let image = props.logo

const submit = () => {
    const formData = new FormData();
    formData.append('logo', form.logo);

    form.post(route('admin.logo.store'), {
        data: formData,
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset('logo');
            image = res.props.logo;
        },
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
};

const getImage = (event) => {
    form.logo = event.target.files[0];
}

</script>

<template>
    <AdminLayout title="Create">
        <div class="px-[2rem]">
            <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
                <p class="text-xl font-bold">LOGO</p>
                <div>
                    <img :src="`/${image?.logo}`" width="150" height="150" />
                </div>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <FileInput id="logo" type="file" class="block w-full mt-1" @change="getImage" required />
                            <InputError class="mt-2" :message="form.errors.logo" />
                        </div>

                    </div>
                    <PrimaryButton class="mt-2">
                        Save
                    </PrimaryButton>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
