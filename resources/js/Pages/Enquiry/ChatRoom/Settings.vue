<script setup>
import ChemicalDetailsCard from "@/components/ChemicalDetailsCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LogoutIcon from "@/Icons/LogoutIcon.vue";
import { ref } from "vue";
import DialogModal from "@/Components/DialogModal.vue";
import AddUserIcon from "@/Icons/AddUserIcon.vue";
import BinIcon from "@/Icons/BinIcon.vue";
import ChatRoomLayout from "@/Layouts/ChatRoomLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";
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

const page = usePage();
const showPeople = ref(false);

const staff = ref([]);
const openModal = () => {
    showPeople.value = true;
};
const closeModal = () => {
    showPeople.value = false;
};

const addUser = () => {
    axios
        .post(
            route("enquiry.chatroom.addUser", {
                id: props.chatroom.id,
                staff: staff.value,
            })
        )
        .then((res) => {
            console.log(res.data);
            // window.location.reload()
            showPeople.value = false;
        });
};

const leaveChat = () => {

    if(!confirm('Are u sure u wanna leave the group')){
        return
    }
    const form = useForm({ user: page.props.value.user.id });

    form.post(route("chatroom.exitGroup", { chatroom: props.chatroom }));
};

const deleteMessages = () => {
    const form = useForm({ user: page.props.value.user.id });

    form.post(route("chatroom.deleteMessages", { chatroom: props.chatroom }));
};
</script>

<template>
    <ChatRoomLayout
        title="Chatrom"
        :name="`My Enquiry - ${props.chatroom.name}`"
    >
        <div class="max-w-[40rem] m-auto">
            <div class="px-2 flex-1 mb-[5rem] w-full">
                <ChemicalDetailsCard
                    :details="product"
                    :link="null"
                />
                <div class="p-2 mt-2 bg-white">
                    <p class="text-sm font-bold text-gray-600">
                        {{ props.memberCount }} participants
                    </p>
                    <button
                        v-if="auth_member.pivot.chat_left == 0"
                        @click="openModal"
                        class="flex items-center gap-2 p-2"
                    >
                        <div class="p-1 bg-green-500 rounded-full">
                            <AddUserIcon class="text-white" />
                        </div>
                        <p>Add participants</p>
                    </button>
                    <div
                        v-for="member in props.members"
                        class="flex gap-2 mb-2"
                    >
                        <div>
                            <img
                                :src="member.profile_photo_url"
                                alt="profile image"
                                class="h-[3rem] w-[3rem]"
                            />
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between w-full">
                                <Link
                                    :href="
                                        route('profile.display', {
                                            id: member.id,
                                        })
                                    "
                                    >{{ member.name }}</Link
                                >
                                <!-- <p class="text-xs bg-green-300 px-2 py-[0.2rem] rounded-xl">Admin</p> -->
                            </div>
                            <Link
                                :href="
                                    route('company.show', {
                                        id: member.company.id,
                                    })
                                "
                                >{{ member.company.name }}
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="p-2 mt-2 bg-white">
                    <button
                        v-if="auth_member.pivot.chat_left == 0"
                        @click="leaveChat"
                        class="flex gap-4 p-2"
                    >
                        <LogoutIcon class="text-red-500" />
                        <p class="text-red-500">Exit group</p>
                    </button>
                    <button @click="deleteMessages" class="flex gap-4 p-2">
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
                <div
                    v-for="employee in employees"
                    class="flex items-center gap-2 mb-2"
                >
                    <input
                        type="checkbox"
                        name="staff"
                        :value="employee.id"
                        v-model="staff"
                    />
                    <label for="name">{{ employee.name }}</label>
                </div>
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Ok </SecondaryButton>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <PrimaryButton @click="addUser" class="ml-4"> Add </PrimaryButton>
        </template>
    </DialogModal>
</template>
