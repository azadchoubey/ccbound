<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import ArrowRightIcon from '../Icons/ArrowRightIcon.vue';
import BuildingIcon from '../Icons/BuildingIcon.vue';
import ContactsIcon from '../Icons/ContactsIcon.vue';
import HelpIcon from '../Icons/HelpIcon.vue';
import MoneyIcon from '../Icons/MoneyIcon.vue';
import SubscriptionIcon from '../Icons/SubscriptionIcon.vue';
import UserGroupIcon from '../Icons/UserGroupIcon.vue';
import UserIcon from '../Icons/UserIcon.vue';
import WalletIcon from '../Icons/WalletIcon.vue';
import SettingsLayout from '../Layouts/SettingsLayout.vue';
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const logout = () => {
  Inertia.post(route("logout"));
};

</script>

<template>
    <SettingsLayout title="Settings">
        <div class="bg-white max-w-[40rem] md:mt-2">
            <div class="p-2 flex justify-between">
                <p class="px-2 text-2xl font-bold">Settings</p>
            </div>

            <div class="flex flex-col gap-5 mt-5 p-4">
                <Link :href="route('profile.display',{id:$page.props.user.id})" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bg-green-500 p-1 rounded-lg"> <UserIcon class="text-white"/> </div>
                        My Profile
                    </div>
                    <ArrowRightIcon />
                </Link>
                <Link :href="route('company.manage')" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bg-slate-900 p-1 rounded-lg"> <BuildingIcon class="text-white"/> </div>
                        Manage Company
                    </div>
                    <ArrowRightIcon />
                </Link>
                <button @click="logout" class="bg-red-500 text-white py-2 rounded-lg font-semibold">Logout</button>
            </div>
        
        </div>
    </SettingsLayout>
</template>
