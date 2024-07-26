<script setup>
import ChemicalDetailsCard from "@/components/ChemicalDetailsCard.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import LogoutIcon from "@/Icons/LogoutIcon.vue";
import { ref } from "vue";
import DialogModal from "@/Components/DialogModal.vue";
import AddUserIcon from "@/Icons/AddUserIcon.vue";
import BinIcon from "@/Icons/BinIcon.vue";
import ChatRoomLayout from "@/Layouts/ChatRoomLayout.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3';
const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    chatroom: Object,
    members: Object,
    memberCount: Number,
    employees: Object,
    auth_member: Object,
    product: Object,
});

const showPeople = ref(false)

const staff = ref([])

const openModal = () => {
    showPeople.value = true
}
const closeModal = () => {
    showPeople.value = false
}

const clicked = () => {
    console.log('asdfasdf')
}

const addUser = () => {
    axios.post(route('sale.chatroom.addUser',{'id':props.chatroom.id,'staff':staff.value}))
    .then( res => {
        window.location.reload()
        showPeople.value = false
    })
}

const leaveChat = () =>{


    if(!confirm('Are u sure u wanna leave the group')){
        return
    }
    const form = useForm({user:page.props.value.user.id});

    form.post(route('chatroom.exitGroup',{chatroom:props.chatroom}));
}

const deleteMessages = () =>{
    const form = useForm({user:page.props.value.user.id});

    form.post(route('chatroom.deleteMessages',{chatroom:props.chatroom}));
}
</script>

<template>
    <ChatRoomLayout title="Chatrom" :name="`My Sale - ${props.chatroom.name}`" :profile_image="`/assests/images/avatar.jpg`">
        <div class="max-w-[40rem] m-auto">
            <div class="px-2 flex-1 mb-[5rem] w-full">
                <ChemicalDetailsCard
                    :details="product"
                    :link="null"
                />

                <div class="bg-white mt-2 p-2">
                    <p class="text-sm text-gray-600 font-bold">{{ props.memberCount }} participants</p>
                    <button v-if="auth_member.pivot.chat_left == 0" @click="openModal" class="p-2 flex items-center gap-2">
                        <div class="bg-green-500 p-1 rounded-full">
                            <AddUserIcon class="text-white" />
                        </div>
                        <p>Add participants</p>
                    </button>
                    <div v-for="member in props.members" class="flex gap-2 mb-2" @click="clicked">
                        <div>
                            <img :src="member.profile_photo_url" alt="profile image" class="h-[3rem] w-[3rem]">
                        </div>
                        <div class="w-full">
                            <div class="w-full flex justify-between">
                                <Link :href="route('profile.display', { 'id': member.id })">{{ member.name }}</Link>
                                <!-- <p class="text-xs bg-green-300 px-2 py-[0.2rem] rounded-xl">Admin</p> -->
                            </div>
                            <Link :href="route('company.show', { 'id': member.company.id })">{{ member.company.name }}
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="bg-white mt-2 p-2">
                    <button v-if="auth_member.pivot.chat_left == 0" @click="leaveChat" class="flex p-2 gap-4">
                        <LogoutIcon class="text-red-500" />
                        <p class="text-red-500">Exit group</p>
                    </button>
                    <button  @click="deleteMessages" class="flex p-2 gap-4">
                        <BinIcon class="text-red-500" />
                        <p class="text-red-500">Delete Chat</p>
                    </button>
                </div>
            </div>

        </div>
    </ChatRoomLayout>

    <DialogModal :show="showPeople" @close="closeModal">
        <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add People</p>

                    <div v-for="employee in employees" class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="staff" :value="employee.id" v-model="staff">
                        <label for="name">{{ employee.name }}</label>
                    </div>
                </div>
            </template>
        <template #footer>
        <SecondaryButton @click="closeModal">
          Cancel
        </SecondaryButton>

        <PrimaryButton @click="addUser" class="ml-4">
          Add
        </PrimaryButton>
      </template>
    </DialogModal>
</template>
