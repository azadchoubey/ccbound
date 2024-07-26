<script setup>
import ArrowRightIcon from '@/Icons/ArrowRightIcon.vue';
import BuildingIcon from '@/Icons/BuildingIcon.vue';
import { Link } from '@inertiajs/inertia-vue3';
import ArrowLeftIcon from '../../Icons/ArrowLeftIcon.vue';
import EditIcon from '../../Icons/EditIcon.vue';
import PlusIcon from '../../Icons/PlusIcon.vue';
import UserGroupIcon from '../../Icons/UserGroupIcon.vue';
import SettingsLayout from '../../Layouts/SettingsLayout.vue';
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <SettingsLayout title="Settings">
        <div class="lg:hidden w-full flex gap-2 border-b bg-white border-gray-200 py-[1rem] px-[1rem]">
                <Link :href="route('settings')">
                    <ArrowLeftIcon />
                </Link>
                <p>Manage Company</p>
            </div>
        <div class="bg-white max-w-[40rem]">

            <div class="flex flex-col gap-5 p-4 mt-5">
                <Link :href="route('company.show',{id:$page.props.user.company.id})" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1 bg-green-500 rounded-lg"> <BuildingIcon class="text-white"/> </div>
                        Company
                    </div>
                    <ArrowRightIcon />
                </Link>
                <Link v-if="$page.props.user.role === 'admin'" :href="route('users.index')" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1 rounded-lg bg-slate-900"> <UserGroupIcon class="text-white"/> </div>
                        Users
                    </div>
                    <ArrowRightIcon />
                </Link>
                <!-- <Link :href="route('product.create')" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1 bg-purple-500 rounded-lg"> <PlusIcon class="text-white"/> </div>
                        Add Product
                    </div>
                    <ArrowRightIcon />
                </Link> -->
            </div>
        
        </div>
    </SettingsLayout>
</template>
