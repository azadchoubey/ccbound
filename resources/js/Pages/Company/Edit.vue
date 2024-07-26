<script setup>
import SectionBorder from '@/Components/SectionBorder.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateCompanyInformationForm from '@/Pages/Company/Partials/UpdateCompanyInformationForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    company: Object,
    countries: Array
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Profile
            </h2>
        </template>

        <div>
            <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateCompanyInformationForm :company="company" :countries="countries" />

                    <SectionBorder />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
