<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchInput from "@/components/SearchInput.vue";
import ChemicalDetailsCard from "../../components/ChemicalDetailsCard.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import UserCard from "../../Components/UserCard.vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});

const tab = ref("all");

const setTab = (tabValue) => {
  tab.value = tabValue;
};

</script>

<style scoped>
.star {
  visibility: hidden;
  font-size: 30px;
  cursor: pointer;
}

.star:before {
  content: "\2606";
  position: absolute;
  top: -10px;
  display: block;
  color: black;
  visibility: visible;
}

.star:checked:before {
  content: "\2605";
  top: -10px;
  color: yellow;
  position: absolute;
}
</style>
<template>
  <AppLayout title="Chats">
    <div class="max-w-[45rem]">
      <div class="px-2 flex flex-col bg-white">
        <div class="bg-white p-[1rem]">
          <p class="text-xl font-bold">My Enquiry</p>
          <p class="text-xl font-bold">Benzene</p>
          <p>111-111-111</p>
        </div>
      </div>
      <div class="px-2 md:px-0 mt-2">
        <SearchInput class="w-full bg-gray-200 p-2" placeholder="Search" />

        <div class="mt-4">
          <div class="my-5">
            <p class="font-bold text-xl">Share message</p>
            <form action="">
              <textarea class="w-full rounded-lg focus:outline-none" required></textarea>
              <div class="w-full flex justify-end">
                <button class="bg-blue-600 px-4 py-2 rounded-lg text-sm text-white">Share</button>
              </div>
            </form>
          </div>

          <div class="flex justify-between items-center pr-[2rem]">
            <input type="checkbox" name="" id="">
            <button class="bg-black text-white px-4 py-2 rounded-lg text-sm">Block</button>
            <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">Delete</button>
          </div>
          <div class="grid grid-cols-2 border-b-[1px] border-gray-200">
            <button @click="setTab('all')" :class="`${
              tab === 'all' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
              <p :class="` ${tab === 'all' ? 'font-bold' : ''
              } w-full flex justify-center`">
                All Chats
              </p>
            </button>
            <button @click="setTab('starred')" :class="`${tab === 'starred' ? 'border-b-[1px] pb-2 border-black' : ''
            } transition-all duration-500`">
              <p :class="` ${tab === 'starred' ? 'font-bold' : ''} w-full flex justify-center`">
                Starred
              </p>
            </button>
          </div>
          <div v-for="n in 10" class="mt-4" :class="`bg-white flex items-center gap-2 px-[0.2rem]`">
            <input type="checkbox" class="block">
            <div class="relative">
              <input class="star" type="checkbox" title="bookmark page">
            </div>
            <Link :href="route('chats.show', { id: '1' })">
            <UserCard :profile_image="'/assests/images/avatar.jpg'" :name="'Rakesh'" :companyName="'Reoslute B2B'"
              :last_message="`LoremLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,`" />
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
