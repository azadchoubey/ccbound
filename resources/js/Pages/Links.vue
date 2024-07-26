<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import ArrowRightIcon from '../Icons/ArrowRightIcon.vue';
import BuildingIcon from '../Icons/BuildingIcon.vue';
import ContactsIcon from '../Icons/ContactsIcon.vue';
import HelpIcon from '../Icons/HelpIcon.vue';
import MoneyIcon from '../Icons/MoneyIcon.vue';
import PlusIcon from '../Icons/PlusIcon.vue';
import SubscriptionIcon from '../Icons/SubscriptionIcon.vue';
import UserGroupIcon from '../Icons/UserGroupIcon.vue';
import UserIcon from '../Icons/UserIcon.vue';
import WalletIcon from '../Icons/WalletIcon.vue';
import SettingsLayout from '../Layouts/SettingsLayout.vue';
// import SettingsIconSolid from '../Icons/SettingsIconSolid.vue';
import Loader from '../Components/Loader.vue';
import LogoutIcon from "../Icons/LogoutIcon.vue";
import { ref } from "vue";
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const showLocation = ref(false);

const logout = () => {
    showLocation.value = true;
    setTimeout(function() {
        Inertia.post(route('logout'), {}, {
    onSuccess: () => {
        window.location.href = '/';
    }
});
       
    }, 1000);
    
};



</script>
<style>
.loader {
    border: 16px solid #f3f3f3;
    /* Light grey */
    border-top: 16px solid #3498db;
    /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
<template>
    <SettingsLayout title="Settings">
        <div class="bg-white max-w-[40rem] md:mt-2">
            <div class="flex justify-between p-2">
                <p class="px-2 text-2xl font-bold">Settings</p>
            </div>

            <div class="flex flex-col gap-5 p-4 mt-5">
                <Link :href="route('profile.display', { id: $page.props.user.id })" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-purple-500 rounded-lg">
                        <UserIcon class="text-white" />
                    </div>
                    My Profile
                </div>
                <ArrowRightIcon />
                </Link>
                <!-- <Link :href="route('product.create')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-purple-500 rounded-lg">
                        <PlusIcon class="text-white" />
                    </div>
                    Add Product
                </div>
                <ArrowRightIcon />
                </Link> -->
                <Link :href="route('company.manage')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 rounded-lg bg-slate-900">
                        <BuildingIcon class="text-white" />
                    </div>
                    Manage Company
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('subscription.create')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 rounded-lg bg-lime-500">
                        <SubscriptionIcon class="text-white" />
                    </div>
                    Subscription
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('buy')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-indigo-500 rounded-lg">
                        <MoneyIcon class="text-white" />
                    </div>
                    Buy Product upload pack
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('wallet')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-yellow-500 rounded-lg">
                        <WalletIcon class="text-white" />
                    </div>
                    Wallet
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('contacts')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-orange-500 rounded-lg">
                        <ContactsIcon class="text-white" />
                    </div>
                    Contacts
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('refer')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 rounded-lg bg-rose-500">
                        <UserGroupIcon class="text-white" />
                    </div>
                    Refer and Earn
                </div>
                <ArrowRightIcon />
                </Link>
                <Link :href="route('help')" class="flex justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1 bg-gray-500 rounded-lg">
                        <HelpIcon class="text-white" />
                    </div>
                    Help
                </div>
                <ArrowRightIcon />
                </Link>
                <!-- <Link :href="route('settings')" class="flex justify-between">
                    <div class="flex items-center gap-2">
                    <div class="p-1 bg-black rounded-lg">
                    <SettingsIconSolid class="text-white" />
                </div>Settings</div>
                <ArrowRightIcon />
                </Link> -->

                <button @click="logout" class="flex justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1 bg-blue-400 rounded-lg">
                            <LogoutIcon class="text-white" />
                        </div>Logout
                    </div>
                    <ArrowRightIcon />
                </button>

            </div>

        </div>
    </SettingsLayout>
    <Loader :show="showLocation" @close="showLocation = !showLocation">

        <template #content>
            <center>
                <div class="loader"></div>
                <p class="mt-3">Wait for a Second</p>
            </center>
        </template>
       
    </Loader>
</template>
