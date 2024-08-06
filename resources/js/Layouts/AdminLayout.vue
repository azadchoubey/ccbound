<script setup>
import Banner from "@/Components/Banner.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";

import BuildingIcon2 from "../Icons/BuildingIcon2.vue";
import GiftIcon from "../Icons/GiftIcon.vue";
import HomeIcon from "../Icons/HomeIcon.vue";
import UserGroupIcon from "../Icons/UserGroupIcon.vue";
import EnquiryIcon from "../Icons/EnquiryIcon.vue";
import MoneyIcon from "../Icons/MoneyIcon.vue";
import LogoutIcon from "../Icons/LogoutIcon.vue";
import { ref } from "vue";
import ToastList from "../Components/ToastList.vue";

defineProps({
  title: String,
});

const viewMenu = ref(true);

const logout = () => {
  Inertia.post(route("logout"));
};
</script>

<template>
  <div class="max-h-screen bg-gray-100">
    <Head :title="`Admin ${title}`" />

    <ToastList />
    
    <Banner />

    <div class="flex">
      <div class="min-h-screen">
        <div
          :class="`${
            viewMenu ? 'w-[18rem]' : 'w-[6rem]'
          } transition-all bg-slate-800 fixed h-full w-[18rem] overflow-y-auto scrollbar-hide`"
        >
          <div class="flex justify-between p-[2rem]">
            <p v-if="viewMenu" class="text-xl text-white">Admin</p>
            <button @click="viewMenu = !viewMenu">
              <BarsLeftIcon class="text-white" />
            </button>
          </div>
          <div class="py-[1rem]">
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'accounts_admin'"
              :href="route('admin.user.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <HomeIcon />
              <p v-if="viewMenu">Home</p>
            </Link>
            <!-- <Link
              :href="route('admin.user.pending')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <UserGroupIcon />
              <p v-if="viewMenu">Pending Activations</p>
            </Link> -->
            <Link
              v-if="$page.props.user.role === 'super_admin'"
              :href="route('admin.admin.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <UserGroupIcon />
              <p v-if="viewMenu">Admins</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'accounts_admin'"
              :href="route('admin.company.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <BuildingIcon2 />
              <p v-if="viewMenu">Companies</p>
            </Link>
            <!-- <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'accounts_admin'"
              :href="route('admin.country.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <BuildingIcon2 />
              <p v-if="viewMenu">Country</p>
            </Link> -->
            
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'data_admin'"
              :href="route('admin.sale.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <MoneyIcon />
              <p v-if="viewMenu">Sales</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'data_admin'"
              :href="route('admin.enquiry.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <EnquiryIcon />
              <p v-if="viewMenu">Enquiries</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'data_admin'"
              :href="route('admin.product.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <HomeIcon />
              <p v-if="viewMenu">Products</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin'"
              :href="route('admin.logo.create')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <BuildingIcon2 />
              <p v-if="viewMenu">Logo</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'data_admin'"
              :href="route('admin.uploadpack.showlist')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <HomeIcon />
              <p v-if="viewMenu">Upload Products</p>
            </Link>
            <Link
            v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.coupon.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <GiftIcon />
              <p v-if="viewMenu">Coupon codes</p>
            </Link>
            <Link
            v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.subscription.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <GiftIcon />
              <p v-if="viewMenu">Subscription</p>
            </Link>
            <Link
            v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.uploadpack.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <GiftIcon />
              <p v-if="viewMenu">Buy Upload Pack</p>
            </Link>
            <Link
            v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.subscription.payments')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <MoneyIcon />
              <p v-if="viewMenu">Subscription Payments</p>
            </Link>
            <Link
            v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.uploadpack.payments')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <MoneyIcon />
              <p v-if="viewMenu">UploadPack Payments</p>
            </Link>
            <Link
              v-if="$page.props.user.role === 'super_admin' || $page.props.user.role === 'sales_admin'"
              :href="route('admin.payout.index')"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <MoneyIcon />
              <p v-if="viewMenu">Payouts</p>
            </Link>
            <Link
              @click="logout"
              :class="`${
                viewMenu ? 'px-[3rem]' : 'px-[2rem]'
              } text-gray-300 flex gap-2 items-center py-[1rem] hover:bg-black/50`"
            >
              <LogoutIcon />
              <p v-if="viewMenu">Logout</p>
            </Link>
          </div>
        </div>
      </div>
      <main
        :class="`${
          viewMenu ? 'ml-[18rem]' : 'ml-[6rem]'
        } transition-all bg-gray-100 h-full w-full`"
      >
        <div class="bg-white flex justify-between p-[2rem]">
          <p class="text-xl font-bold">{{ title }}</p>
          <div class="flex items-center gap-2">
            <img
              :src="$page.props.user.profile_photo_url"
              class="h-[3rem] rounded-full"
              alt="profile image"
            />
            <p class="font-bold text-gray-500">{{ $page.props.user.name }}</p>
          </div>
        </div>
        <slot />
      </main>
    </div>
  </div>
</template>
