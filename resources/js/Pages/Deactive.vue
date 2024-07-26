<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

</script>

<template>
    <Head title="Account Deactivate" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Your account has been deactivated please contact the admin
        </div>


        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">

                <div class="w-full flex justify-center">
                    <Link :href="route('logout')" method="post" as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                    Log Out
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
