<script setup>
import LogoutIcon from "@/Icons/LogoutIcon.vue";
import { ref } from "vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ChemicalDetailsCard from "../../Components/ChemicalDetailsCard.vue";
import DialogModal from "../../Components/DialogModal.vue";
import ChatRoomLayout from "../../Layouts/ChatRoomLayout.vue";
import BinIcon from "../../Icons/BinIcon.vue";
import AddUserIcon from "../../Icons/AddUserIcon.vue";
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const showPeople = ref(false)
const openModal = () => {
    showPeople.value = true
}
const closeModal = () => {
    showPeople.value = false
}
</script>

<template>
    <ChatRoomLayout title="Chatrom" :navigationBack="'/chats/1'" :infoLink="`/chat/settings/asdf`"
        :name="'Chatroom Name'" :profile_image="`/assests/images/avatar.jpg`">
        <div class="max-w-[40rem] m-auto">
            <div class="px-2 flex-1 mb-[5rem] w-full">
                <!-- <div class="w-full">
                    <ChemicalDetailsCard class="mt-2" :chemicalName="'Benzene'" :image="'asdf'" :casNo="'111-111-1111'"
                        :description="`Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,`"
                        :userName="'Rakesh'" :company="'ResoluteB2B'" :location="'Hyderabad'"
                        :link="route('enquiry.show', { id: '1' })" :showImage=true :showFooter=false />
                </div> -->

                <div class="p-2 mt-2 bg-white">
                    <p class="text-sm font-bold text-gray-600">8 participants</p>
                    <button @click="openModal" class="flex items-center gap-2 p-2">
                        <div class="p-1 bg-green-500 rounded-full">
                            <AddUserIcon class="text-white" />
                        </div>
                        <p>Add participants</p>
                    </button>
                    <div class="flex gap-2 mb-2">
                        <div>
                            <img :src="`/assests/images/avatar.jpg`" alt="profile image" class="h-[3rem]">
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between w-full">
                                <p>Rakesh</p>
                                <p class="text-xs bg-green-300 px-2 py-[0.2rem] rounded-xl">Admin</p>
                            </div>
                            <div>ResoluteB2B</div>
                        </div>
                    </div>

                    <div class="flex gap-2 mb-2">
                        <div>
                            <img :src="`/assests/images/avatar.jpg`" alt="profile image" class="h-[3rem]">
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between w-full">
                                <p>Rakesh</p>
                                <p class="text-xs bg-green-300 px-2 py-[0.2rem] rounded-xl">Admin</p>
                            </div>
                            <div>ResoluteB2B</div>
                        </div>
                    </div>

                    <div class="flex gap-2 mb-2">
                        <div>
                            <img :src="`/assests/images/avatar.jpg`" alt="profile image" class="h-[3rem]">
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between w-full">
                                <p>Rakesh</p>
                                <!-- <p class="text-xs bg-green-300 px-2 py-[0.2rem] rounded-xl">Admin</p> -->
                            </div>
                            <div>ResoluteB2B</div>
                        </div>
                    </div>
                </div>

                <div class="p-2 mt-2 bg-white">
                    <div class="flex gap-4 p-2">
                        <LogoutIcon class="text-red-500" />
                        <p class="text-red-500">Exit group</p>
                    </div>
                    <div class="flex gap-4 p-2">
                        <BinIcon class="text-red-500" />
                        <p class="text-red-500">Delete Chat</p>
                    </div>
                </div>
            </div>

        </div>
    </ChatRoomLayout>

    <DialogModal :show="showPeople" @close="closeModal">
        <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add People</p>

                    <div class="flex">
                    <select name="" id="">
                        <option value="">User</option>
                        <option value="">Company</option>
                    </select>
                    <input type="text" name="" id="" class="flex-1">
                </div>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="enquiries" id="enquiries">
                        <label for="name">Kishore (ResoluteB2B)</label>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="enquiries" id="enquiries">
                        <label for="name">Kishore (ResoluteB2B)</label>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="enquiries" id="enquiries">
                        <label for="name">Kishore (ResoluteB2B)</label>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="enquiries" id="enquiries">
                        <label for="name">Kishore (ResoluteB2B)</label>
                    </div>
                </div>
            </template>
        <template #footer>
            <SecondaryButton @click="closeModal">
          Ok
        </SecondaryButton>
        <SecondaryButton @click="closeModal">
          Cancel
        </SecondaryButton>

        <PrimaryButton class="ml-4">
          Add
        </PrimaryButton>
      </template>
    </DialogModal>
</template>
